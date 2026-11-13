/**
 * Course Study Portal Controller — 3-Tier Hierarchy (Modules -> Chapters -> Topics & Quizzes)
 * DoctorsInnElite - Learning Management System
 * File: public/frontend/js/course-portal.js
 */

// Global database reference (loaded from my-courses-data.js)
const getDb = () => (typeof myCoursesData !== 'undefined' ? myCoursesData : (typeof coursesDatabase !== 'undefined' ? coursesDatabase : {}));

// Global State
let activeCourseId = "mdcat-reboot-60-day";
let activeModuleFilter = "all"; // "all" or specific module ID
let activeTypeFilter = "all";   // "all" | "topics" | "quizzes"
let activeTopicId = "";

// Quiz Studio Runtime State
let currentQuizTopic = null;
let activeQuizData = null;
let currentQuestionIdx = 0;
let userSelections = [];
let checkedStatus = [];
let quizTimerInterval = null;
let timeRemainingSec = 0;
let timeSpentSec = 0;

// =============================================================================
// 1. DATA NORMALIZATION (3-Tier: Course -> Modules -> Chapters -> Topics & Quizzes)
// =============================================================================

function getActiveCourseId() {
    const db = getDb();
    const urlParams = new URLSearchParams(window.location.search);
    let courseId = urlParams.get("course");

    if (!courseId) {
        const pathParts = window.location.pathname.split('/').filter(Boolean);
        const studyIdx = pathParts.findIndex(p => p === "my-courses" || p === "classroom");
        if (studyIdx !== -1 && pathParts[studyIdx + 1]) {
            courseId = pathParts[studyIdx + 1];
        }
    }

    if (courseId && db[courseId]) {
        return courseId;
    }

    const keys = Object.keys(db);
    return keys.length > 0 ? (db["mdcat-reboot-60-day"] ? "mdcat-reboot-60-day" : keys[0]) : "mdcat-reboot-60-day";
}

function getModuleIcon(name = "") {
    const lower = name.toLowerCase();
    if (lower.includes("bio")) return "fa-solid fa-dna";
    if (lower.includes("chem")) return "fa-solid fa-flask-vial";
    if (lower.includes("phy")) return "fa-solid fa-bolt";
    if (lower.includes("eng") || lower.includes("logic")) return "fa-solid fa-brain";
    return "fa-solid fa-layer-group";
}

/**
 * Normalizes course content so it always returns a structured array of:
 * Modules -> Chapters -> Topics & Quizzes
 */
function normalizeCourseContent(course) {
    if (!course) return [];

    // Case 1: Course has modules with nested chapters
    if (Array.isArray(course.modules) && course.modules.length > 0) {
        return course.modules.map((mod, modIdx) => {
            const modId = mod.id || `module-${modIdx + 1}`;
            const modName = mod.name || `Module ${modIdx + 1}`;
            const modIcon = mod.icon || getModuleIcon(modName);

            // If module already has structured chapters
            if (Array.isArray(mod.chapters) && mod.chapters.length > 0) {
                const chapters = mod.chapters.map((ch, chIdx) => {
                    const chId = ch.id || `${modId}-ch-${chIdx + 1}`;
                    const chName = ch.name || `Chapter ${chIdx + 1}`;
                    const topics = (ch.topics || []).map((tp, tpIdx) => {
                        const isQuiz = Boolean(tp.isQuiz || tp.type === "quiz");
                        const quizType = tp.quizType || (tp.isChapterQuiz ? "chapter" : "topic");
                        return {
                            id: tp.id || `${chId}-tp-${tpIdx + 1}`,
                            topicNumber: tp.topicNumber || `${modIdx + 1}.${chIdx + 1}.${tpIdx + 1}`,
                            title: tp.title || `Topic ${tpIdx + 1}`,
                            type: isQuiz ? "quiz" : (tp.type || "video"),
                            isQuiz: isQuiz,
                            quizType: quizType,
                            duration: tp.duration || (isQuiz ? "5 min" : "35 min"),
                            videoUrl: tp.videoUrl || "",
                            readContent: tp.readContent || "",
                            resources: tp.resources || course.defaultResources || [],
                            quizData: tp.quizData || (isQuiz ? generateFallbackQuiz(tp.title) : null),
                            moduleId: modId,
                            moduleName: modName,
                            chapterId: chId,
                            chapterName: chName
                        };
                    });
                    return {
                        id: chId,
                        chapterNumber: ch.chapterNumber || chIdx + 1,
                        name: chName,
                        description: ch.description || "",
                        moduleId: modId,
                        moduleName: modName,
                        topics: topics
                    };
                });

                return {
                    id: modId,
                    name: modName,
                    icon: modIcon,
                    description: mod.description || "",
                    chapters: chapters
                };
            }

            // If module has legacy lessons, convert them into Chapters with Topics & Quizzes
            const cleanModName = mod.name.replace(/^Module\s*\d+\s*:\s*/i, "");
            const chId = `${modId}-ch-1`;
            const chName = `Chapter 1: ${cleanModName} Fundamentals`;

            const topics = [];
            (mod.lessons || []).forEach((les, lesIdx) => {
                const isQuiz = Boolean(les.isQuiz || les.type === "quiz");
                const cleanTitle = les.title.replace(/^Lesson\s*\d+\s*[-—:]\s*/i, "");

                topics.push({
                    id: les.id,
                    topicNumber: `1.${lesIdx + 1}`,
                    title: `Topic 1.${lesIdx + 1}: ${cleanTitle}`,
                    type: isQuiz ? "quiz" : (les.type || "video"),
                    isQuiz: isQuiz,
                    quizType: isQuiz ? (les.quizType || "topic") : "topic",
                    duration: les.duration || "30 min",
                    videoUrl: les.videoUrl || "",
                    readContent: les.readContent || "",
                    resources: les.resources || course.defaultResources || [],
                    quizData: les.quizData || (isQuiz ? generateFallbackQuiz(les.title) : null),
                    moduleId: modId,
                    moduleName: modName,
                    chapterId: chId,
                    chapterName: chName
                });

                // Synthesize a Checkpoint Topic Quiz after the first video topic if none exists
                if (lesIdx === 0 && !isQuiz && (mod.lessons.length > 1 || !mod.lessons.some(l => l.isQuiz))) {
                    const quizTopicId = `${les.id}-quiz`;
                    topics.push({
                        id: quizTopicId,
                        topicNumber: "1.1 Checkpoint",
                        title: `Topic 1.1 Quick Quiz: Concept Check`,
                        type: "quiz",
                        isQuiz: true,
                        quizType: "topic",
                        duration: "5 min",
                        videoUrl: "",
                        readContent: "",
                        resources: course.defaultResources || [],
                        quizData: generateFallbackQuiz(`Topic 1.1: ${cleanTitle}`),
                        moduleId: modId,
                        moduleName: modName,
                        chapterId: chId,
                        chapterName: chName
                    });
                }
            });

            // Synthesize a Chapter Comprehensive Quiz at chapter end
            const hasChapterEndQuiz = topics.some(t => t.quizType === "chapter");
            if (!hasChapterEndQuiz) {
                const chQuizId = `${chId}-assessment`;
                topics.push({
                    id: chQuizId,
                    topicNumber: "Assessment",
                    title: `${chName} — Mastery Assessment`,
                    type: "quiz",
                    isQuiz: true,
                    quizType: "chapter",
                    duration: "10 min",
                    videoUrl: "",
                    readContent: "",
                    resources: course.defaultResources || [],
                    quizData: generateFallbackQuiz(chName, 5, 80, 10, true),
                    moduleId: modId,
                    moduleName: modName,
                    chapterId: chId,
                    chapterName: chName
                });
            }

            return {
                id: modId,
                name: modName,
                icon: modIcon,
                description: mod.description || "",
                chapters: [
                    {
                        id: chId,
                        chapterNumber: 1,
                        name: chName,
                        description: mod.description || "",
                        moduleId: modId,
                        moduleName: modName,
                        topics: topics
                    }
                ]
            };
        });
    }

    // Case 2: Course has direct chapters at root
    if (Array.isArray(course.chapters) && course.chapters.length > 0) {
        const modId = "module-core";
        const modName = "Module 1: Core Curriculum";
        const chapters = course.chapters.map((ch, chIdx) => {
            const chId = ch.id || `chapter-${chIdx + 1}`;
            const chName = ch.name || `Chapter ${chIdx + 1}`;
            const topics = (ch.topics || []).map((tp, tpIdx) => {
                const isQuiz = Boolean(tp.isQuiz || tp.type === "quiz");
                const quizType = tp.quizType || (tp.isChapterQuiz ? "chapter" : "topic");
                return {
                    id: tp.id || `${chId}-tp-${tpIdx + 1}`,
                    topicNumber: tp.topicNumber || `${chIdx + 1}.${tpIdx + 1}`,
                    title: tp.title || `Topic ${tpIdx + 1}`,
                    type: isQuiz ? "quiz" : (tp.type || "video"),
                    isQuiz: isQuiz,
                    quizType: quizType,
                    duration: tp.duration || (isQuiz ? "5 min" : "35 min"),
                    videoUrl: tp.videoUrl || "",
                    readContent: tp.readContent || "",
                    resources: tp.resources || course.defaultResources || [],
                    quizData: tp.quizData || (isQuiz ? generateFallbackQuiz(tp.title) : null),
                    moduleId: modId,
                    moduleName: modName,
                    chapterId: chId,
                    chapterName: chName
                };
            });
            return {
                id: chId,
                chapterNumber: chIdx + 1,
                name: chName,
                description: ch.description || "",
                moduleId: modId,
                moduleName: modName,
                topics: topics
            };
        });

        return [
            {
                id: modId,
                name: modName,
                icon: "fa-solid fa-graduation-cap",
                description: course.description || "",
                chapters: chapters
            }
        ];
    }

    return [];
}

/**
 * Returns a flat linear array of all topics across all modules and chapters.
 */
function getAllCourseTopics(modules) {
    const list = [];
    modules.forEach(mod => {
        mod.chapters.forEach(ch => {
            ch.topics.forEach(tp => list.push(tp));
        });
    });
    return list;
}

/**
 * Fallback generator for realistic high-yield PMDC quiz MCQs
 */
function generateFallbackQuiz(subjectTitle, count = 5, passScore = 80, timeMins = 5, isChapterExam = false) {
    const questions = [
        {
            question: `In reference to ${subjectTitle}, which of the following is considered the primary physiological regulatory factor according to PMDC guidelines?`,
            options: [
                "Negative feedback inhibition through allosteric control",
                "Passive paracellular osmotic equilibration",
                "Irreversible covalent ligand cleavage",
                "Substrate-level phosphorylation alone"
            ],
            correctIndex: 0,
            explanation: "Negative feedback inhibition represents the quintessential homeostatic mechanism tested in MDCAT biology, preventing toxic substrate accumulation."
        },
        {
            question: "Which of the following cellular processes directly requires energy derived from the hydrolysis of nucleoside triphosphates (ATP/GTP)?",
            options: [
                "Primary active transport via transmembrane pump",
                "Facilitated diffusion through voltage-gated ion channel",
                "Simple osmotic movement of water across aquaporins",
                "Lipid-soluble gas exchange across alveolar membrane"
            ],
            correctIndex: 0,
            explanation: "Primary active transport is characterized by direct coupling of ATP hydrolysis to solute translocation against an electrochemical gradient."
        },
        {
            question: "During high-intensity physiological stress, what metabolic adjustment is observed in mammalian tissue cells?",
            options: [
                "Depletion of intracellular glycogen with lactic acid elevation",
                "Immediate cessation of anaerobic glycolysis",
                "Total inhibition of mitochondrial cytochromes",
                "Accumulation of excess extracellular glucose polymers"
            ],
            correctIndex: 0,
            explanation: "Under high metabolic demand or relative hypoxia, glycolysis increases rapidly with pyruvate reduction to lactate to regenerate NAD+ for continuous ATP supply."
        },
        {
            question: "Which molecular bond provides the primary structural stability in the secondary conformation of proteins (alpha-helix & beta-pleated sheet)?",
            options: [
                "Hydrogen bonds between carbonyl oxygen and amide hydrogen of backbone",
                "Covalent disulfide bridges between distal cysteine residues",
                "Hydrophobic van der Waals forces between nonpolar side chains",
                "Ionic salt bridges between aspartate and lysine groups"
            ],
            correctIndex: 0,
            explanation: "Secondary structures are strictly stabilized by backbone hydrogen bonds occurring at regular periodic intervals along the polypeptide chain."
        },
        {
            question: "In standard Mendelian genetic evaluation, what phenotypic ratio is expected from a cross of two double heterozygotes (AaBb x AaBb) with unlinked genes?",
            options: [
                "9 : 3 : 3 : 1",
                "1 : 2 : 1",
                "3 : 1",
                "1 : 1 : 1 : 1"
            ],
            correctIndex: 0,
            explanation: "The hallmark 9:3:3:1 phenotypic ratio arises from the independent assortment of two non-interacting, unlinked autosomal gene pairs."
        }
    ];

    return {
        title: isChapterExam ? `${subjectTitle} — Comprehensive Assessment` : `${subjectTitle} Practice Quiz`,
        subtitle: isChapterExam ? "PMDC Examination standard comprehensive mastery assessment." : "Rapid-fire concept check questions to test your retention.",
        passingScore: passScore,
        timeLimitMinutes: timeMins,
        questions: questions.slice(0, count)
    };
}

// =============================================================================
// 2. LOCAL STORAGE PERSISTENCE (Completion, Notes, Q&A)
// =============================================================================

function getCompletedItems(courseId) {
    const key = `completed_lessons_${courseId}`;
    try {
        const completed = localStorage.getItem(key);
        return completed ? JSON.parse(completed) : [];
    } catch (e) {
        return [];
    }
}

function setItemCompleted(courseId, itemId, isCompleted) {
    const key = `completed_lessons_${courseId}`;
    let completed = getCompletedItems(courseId);

    if (isCompleted) {
        if (!completed.includes(itemId)) {
            completed.push(itemId);
        }
    } else {
        completed = completed.filter(id => id !== itemId);
    }

    localStorage.setItem(key, JSON.stringify(completed));
    updateProgressUi();
    updateSidebarCheckmarks();
}

function getTopicNotes(topicId) {
    return localStorage.getItem(`notes_${topicId}`) || "";
}

function saveTopicNotes(topicId, content) {
    localStorage.setItem(`notes_${topicId}`, content);
}

function getInstructorImage() {
    return document.getElementById("enrolledCourseSelect")?.dataset.instructorImage || "";
}

function getStudentAvatar(avatar = "") {
    if (/^(https?:)?\/\//i.test(avatar)) {
        return avatar;
    }
    return document.getElementById("enrolledCourseSelect")?.dataset.studentAvatar || "";
}

function getTopicQa(topicId) {
    const key = `qa_${topicId}`;
    try {
        const qa = localStorage.getItem(key);
        return qa ? JSON.parse(qa) : [
            {
                user: "Ali Hassan",
                role: "Student",
                avatar: getStudentAvatar(),
                date: "3 hours ago",
                text: "Is this topic and quiz strictly aligned with the updated PMDC syllabus for the upcoming exam session?"
            },
            {
                user: "DoctorsInn Mentor",
                role: "Instructor",
                avatar: getInstructorImage(),
                date: "2 hours ago",
                text: "Yes, Ali! All modules, chapters, practice quizzes, and comprehensive assessments are 100% mapped to the official MDCAT syllabus."
            }
        ];
    } catch (e) {
        return [];
    }
}

function saveTopicQa(topicId, thread) {
    localStorage.setItem(`qa_${topicId}`, JSON.stringify(thread));
}

// =============================================================================
// 3. CURRICULUM OUTLINE SIDEBAR (Modules -> Chapters -> Topics)
// =============================================================================

function renderModulePills(modules) {
    // Replaced with direct, clean tree outline
}

function renderCurriculumSidebar() {
    const db = getDb();
    const rawCourse = db[activeCourseId];
    if (!rawCourse) return;

    const modules = normalizeCourseContent(rawCourse);
    const accordionContainer = document.getElementById("syllabusAccordion");
    if (!accordionContainer) return;

    accordionContainer.innerHTML = "";

    // Count statistics
    let cntAll = 0;
    let cntTopics = 0;
    let cntQuizzes = 0;

    modules.forEach(mod => {
        mod.chapters.forEach(ch => {
            ch.topics.forEach(tp => {
                cntAll++;
                if (tp.isQuiz) cntQuizzes++;
                else cntTopics++;
            });
        });
    });

    const syllabusItemsEl = document.getElementById("syllabus-items-count");
    if (syllabusItemsEl) {
        syllabusItemsEl.textContent = `${cntAll} items`;
    }

    // Attach click listener for items once
    if (!accordionContainer._hasTopicListener) {
        accordionContainer._hasTopicListener = true;
        accordionContainer.addEventListener("click", event => {
            const topicItem = event.target.closest("[data-topic-id], [data-lesson-id]");
            if (topicItem) {
                const topicId = topicItem.dataset.topicId || topicItem.dataset.lessonId;
                selectActiveTopic(topicId);
            }
        });
    }

    const completedList = getCompletedItems(activeCourseId);

    modules.forEach((mod, modIdx) => {
        // Module Section Header (Clean minimal divider, no heavy boxes)
        const modHeaderHtml = `
            <div class="module-section-title">
                <i class="${mod.icon} text-primary me-2"></i>
                <span>${mod.name}</span>
            </div>
        `;
        accordionContainer.insertAdjacentHTML("beforeend", modHeaderHtml);

        // Render each Chapter in this module
        mod.chapters.forEach((chapter, chIdx) => {
            const safeModId = String(mod.id).replace(/[^a-zA-Z0-9_-]/g, "_");
            const safeChId = String(chapter.id || chIdx).replace(/[^a-zA-Z0-9_-]/g, "_");
            const accordionId = `chCollapse_${safeModId}_${safeChId}`;

            // Check if this chapter contains the active topic
            const containsActive = chapter.topics.some(tp => tp.id === activeTopicId);
            const shouldExpand = containsActive || (modIdx === 0 && chIdx === 0 && !activeTopicId);
            const isShow = shouldExpand ? "show" : "";
            const isExpanded = shouldExpand ? "true" : "false";
            const buttonCollapsed = shouldExpand ? "" : "collapsed";

            let topicsHtml = "";
            chapter.topics.forEach(topic => {
                const isCompleted = completedList.includes(topic.id);
                const completedClass = isCompleted ? "completed" : "";
                const activeClass = topic.id === activeTopicId ? "active" : "";

                let iconClass = "fa-solid fa-play";
                let iconColorClass = "text-muted";

                if (topic.isQuiz) {
                    if (topic.quizType === "chapter") {
                        iconClass = "fa-solid fa-trophy";
                        iconColorClass = "icon-assessment";
                    } else {
                        iconClass = "fa-solid fa-clipboard-question";
                        iconColorClass = "icon-quiz";
                    }
                } else if (topic.type === "reading" || topic.type === "text") {
                    iconClass = "fa-regular fa-file-lines";
                    iconColorClass = "text-muted";
                }

                topicsHtml += `
                    <div class="topic-row ${activeClass} ${completedClass}" id="item-${topic.id}" data-topic-id="${topic.id}" data-lesson-id="${topic.id}">
                        <div class="topic-row-start">
                            <span class="topic-type-icon ${iconColorClass}">
                                <i class="${iconClass}"></i>
                            </span>
                            <span class="topic-title" title="${topic.title}">${topic.title}</span>
                        </div>
                        <div class="topic-row-end">
                            <span class="topic-duration">${topic.duration}</span>
                            <span class="topic-check">
                                <i class="fa-solid fa-circle-check checkmark"></i>
                                <i class="fa-regular fa-circle bullet"></i>
                            </span>
                        </div>
                    </div>
                `;
            });

            const chapterCardHtml = `
                <div class="accordion-item chapter-accordion-item">
                    <h2 class="accordion-header" id="heading_${accordionId}">
                        <button class="accordion-button chapter-accordion-btn ${buttonCollapsed}" type="button" data-bs-toggle="collapse" data-bs-target="#${accordionId}" aria-expanded="${isExpanded}" aria-controls="${accordionId}">
                            <div class="d-flex align-items-center justify-content-between flex-grow-1 min-w-0 pe-2">
                                <span class="chapter-title fw-semibold text-dark text-truncate">${chapter.name}</span>
                                <span class="text-muted text-xs ms-2 flex-shrink-0" style="font-size: 11px;">${chapter.topics.length} items</span>
                            </div>
                        </button>
                    </h2>
                    <div id="${accordionId}" class="accordion-collapse collapse ${isShow}" aria-labelledby="heading_${accordionId}">
                        <div class="accordion-body px-1 py-1 bg-white">
                            ${topicsHtml}
                        </div>
                    </div>
                </div>
            `;
            accordionContainer.insertAdjacentHTML("beforeend", chapterCardHtml);
        });
    });
}

// =============================================================================
// 4. TOPIC & QUIZ SELECTION CONTROLLER
// =============================================================================

function selectActiveTopic(topicId) {
    activeTopicId = topicId;

    const db = getDb();
    const rawCourse = db[activeCourseId];
    if (!rawCourse) return;

    const modules = normalizeCourseContent(rawCourse);
    let activeTopic = null;
    let parentChapter = null;
    let parentModule = null;

    modules.forEach(mod => {
        mod.chapters.forEach(ch => {
            ch.topics.forEach(tp => {
                if (tp.id === topicId) {
                    activeTopic = tp;
                    parentChapter = ch;
                    parentModule = mod;
                }
            });
        });
    });

    if (!activeTopic) return;

    // Highlight active item in sidebar
    document.querySelectorAll(".topic-row, .topic-study-item, .lesson-study-item").forEach(item => {
        item.classList.remove("active");
    });
    const sidebarItem = document.getElementById(`item-${topicId}`);
    if (sidebarItem) {
        sidebarItem.classList.add("active");

        // Automatically expand the chapter accordion if it is collapsed
        const parentCollapse = sidebarItem.closest(".accordion-collapse");
        if (parentCollapse && !parentCollapse.classList.contains("show")) {
            if (window.bootstrap && bootstrap.Collapse) {
                const bsCollapse = bootstrap.Collapse.getOrCreateInstance(parentCollapse, { toggle: false });
                bsCollapse.show();
            } else {
                parentCollapse.classList.add("show");
            }
            const parentBtn = document.querySelector(`[data-bs-target="#${parentCollapse.id}"]`);
            if (parentBtn) {
                parentBtn.classList.remove("collapsed");
                parentBtn.setAttribute("aria-expanded", "true");
            }
        }
        sidebarItem.scrollIntoView({ behavior: "smooth", block: "nearest" });
    }

    // View containers
    const videoContainer = document.getElementById("video-player-container");
    const textBanner = document.getElementById("text-lesson-banner");
    const quizContainer = document.getElementById("quiz-studio-container");
    const videoPlayer = document.getElementById("main-video-player");
    const topicControlRow = document.getElementById("topic-control-row");
    const topicTabsWrapper = document.getElementById("topic-tabs-wrapper");

    // Clear active timer if running
    if (quizTimerInterval) {
        clearInterval(quizTimerInterval);
        quizTimerInterval = null;
    }

    // =========================================================================
    // CASE A: QUIZ STUDIO ITEM (Topic Quiz or Chapter Assessment)
    // =========================================================================
    if (activeTopic.isQuiz) {
        if (videoPlayer) {
            videoPlayer.pause();
            videoPlayer.src = "";
        }
        if (videoContainer) videoContainer.classList.add("d-none");
        if (textBanner) textBanner.classList.add("d-none");
        if (quizContainer) quizContainer.classList.remove("d-none");
        if (topicControlRow) topicControlRow.classList.add("d-none");
        if (topicTabsWrapper) topicTabsWrapper.classList.add("d-none");

        initQuizStudio(activeTopic);
        return;
    }

    // =========================================================================
    // CASE B: NORMAL TOPIC (Video Lecture or High-Yield Reading)
    // =========================================================================
    if (quizContainer) quizContainer.classList.add("d-none");
    if (topicControlRow) topicControlRow.classList.remove("d-none");
    if (topicTabsWrapper) topicTabsWrapper.classList.remove("d-none");

    // Video vs Reading View
    if (activeTopic.type === "video" && activeTopic.videoUrl) {
        if (videoContainer) videoContainer.classList.remove("d-none");
        if (textBanner) textBanner.classList.add("d-none");
        if (videoPlayer) {
            videoPlayer.src = activeTopic.videoUrl;
            videoPlayer.load();
        }
    } else {
        if (videoContainer) videoContainer.classList.add("d-none");
        if (textBanner) textBanner.classList.remove("d-none");
        if (videoPlayer) {
            videoPlayer.pause();
            videoPlayer.src = "";
        }
        const textBannerTitle = document.getElementById("text-banner-title");
        if (textBannerTitle) textBannerTitle.textContent = activeTopic.title;
    }

    // Update 3-Tier Breadcrumbs & Labels
    const modNameEl = document.getElementById("active-module-name");
    const chNameEl = document.getElementById("active-chapter-name");
    const titleEl = document.getElementById("active-topic-title") || document.getElementById("active-lesson-title");
    const durationEl = document.getElementById("active-topic-duration") || document.getElementById("active-lesson-duration");
    const typeEl = document.getElementById("active-topic-type") || document.getElementById("active-lesson-type");
    const badgeEl = document.getElementById("active-topic-badge");

    if (modNameEl) modNameEl.textContent = parentModule ? parentModule.name : "Module";
    if (chNameEl) chNameEl.textContent = parentChapter ? parentChapter.name : "Chapter";
    if (titleEl) titleEl.textContent = activeTopic.title;
    if (durationEl) durationEl.textContent = activeTopic.duration;
    if (typeEl) typeEl.textContent = activeTopic.type === "video" ? "Video Lecture" : "Read Notes / Article";
    if (badgeEl) badgeEl.textContent = activeTopic.type === "video" ? "Video Topic" : "High-Yield Reading";

    // Update Completion status button
    const completedList = getCompletedItems(activeCourseId);
    const isCompleted = completedList.includes(topicId);
    updateCompleteButtonUi(isCompleted);

    // Reading text body
    const readingBody = document.getElementById("lesson-reading-body");
    if (readingBody) {
        readingBody.innerHTML = activeTopic.readContent || `
            <div class="p-4 bg-light rounded-3 text-secondary">
                <h5 class="fw-bold text-dark mb-2">${activeTopic.title}</h5>
                <p class="mb-2">This topic contains high-yield PMDC syllabus core points, conceptual diagrams, and mnemonics.</p>
                <div class="alert alert-info py-2 px-3 text-xs mb-0">
                    <i class="fa-solid fa-circle-info me-1"></i> Video lecture and interactive checkpoints are accessible in the outline.
                </div>
            </div>
        `;
    }

    // Personal Notes
    const notesTextarea = document.getElementById("lesson-notes-textarea");
    if (notesTextarea) {
        notesTextarea.value = getTopicNotes(topicId);
    }
    const notesStatus = document.getElementById("notes-save-status");
    if (notesStatus) notesStatus.classList.add("d-none");

    // Resources (PDFs)
    renderResourcesList(activeTopic, rawCourse);

    // Q&A Feed
    renderQaFeed();

    // Up Next Banner
    updateUpNextBanner(activeTopic, modules);
}

// Backward-compatibility alias
function selectActiveLesson(lessonId) {
    selectActiveTopic(lessonId);
}

function updateUpNextBanner(currentTopic, modules) {
    const allTopics = getAllCourseTopics(modules);
    const currentIdx = allTopics.findIndex(t => t.id === currentTopic.id);
    const upNextBanner = document.getElementById("up-next-banner");
    const upNextTitle = document.getElementById("up-next-title");
    const upNextBtn = document.getElementById("up-next-btn");

    if (!upNextBanner || !upNextTitle || !upNextBtn) return;

    if (currentIdx !== -1 && currentIdx < allTopics.length - 1) {
        const nextTopic = allTopics[currentIdx + 1];
        upNextBanner.classList.remove("d-none");
        upNextTitle.textContent = nextTopic.title;

        upNextBtn.onclick = () => {
            selectActiveTopic(nextTopic.id);
            window.scrollTo({ top: 120, behavior: "smooth" });
        };
    } else {
        upNextTitle.textContent = "Curriculum Completed! Review chapters or retake assessments.";
        upNextBtn.onclick = () => {
            if (allTopics.length > 0) selectActiveTopic(allTopics[0].id);
        };
    }
}

function renderResourcesList(activeTopic, course) {
    const resourcesContainer = document.getElementById("lesson-resources-list");
    if (!resourcesContainer) return;
    resourcesContainer.innerHTML = "";

    if (!resourcesContainer._hasDownloadListener) {
        resourcesContainer._hasDownloadListener = true;
        resourcesContainer.addEventListener("click", event => {
            const downloadButton = event.target.closest("[data-resource-download]");
            if (!downloadButton) return;
            downloadResourceFile(downloadButton.dataset.resourceDownload);
        });
    }

    const allResources = (activeTopic.resources && activeTopic.resources.length > 0)
        ? activeTopic.resources
        : (course.defaultResources || []);

    if (allResources && allResources.length > 0) {
        allResources.forEach(res => {
            const resHtml = `
                <div class="resource-study-box d-flex align-items-center justify-content-between p-3 mb-2 rounded-3 border bg-light">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-2 bg-white border d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-file-pdf text-danger fs-5"></i>
                        </div>
                        <div>
                            <span class="fw-bold d-block text-dark text-sm">${res.name}</span>
                            <span class="text-xs text-muted"><i class="fa-regular fa-download me-1"></i> Verified MDCAT Study Resource &bull; PDF Document</span>
                        </div>
                    </div>
                    <button type="button" data-resource-download="${res.name}" class="btn btn-sm btn-primary py-2 px-3 fw-semibold">
                        <i class="fa-regular fa-arrow-down-to-line me-1"></i> Download PDF
                    </button>
                </div>
            `;
            resourcesContainer.insertAdjacentHTML("beforeend", resHtml);
        });
    } else {
        resourcesContainer.innerHTML = `
            <div class="text-center py-4 text-muted text-sm">
                <i class="fa-regular fa-folder-open mb-2 d-block fs-3"></i>
                No additional resources attached for this topic.
            </div>
        `;
    }
}

function downloadResourceFile(resourceName) {
    const db = getDb();
    const courseTitle = db[activeCourseId] ? db[activeCourseId].title : "DoctorsInn Course";
    const blob = new Blob([
        `DoctorsInnElite - Official Course Material\n\nResource: ${resourceName}\nCourse: ${courseTitle}\nStatus: Verified Enrolled Student Access\n\nBest of luck with your MDCAT Preparation!`
    ], { type: "application/pdf" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = `${resourceName.replace(/\s+/g, "_")}.pdf`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// =============================================================================
// 5. QUIZ STUDIO ENGINE (Start Screen, Question Player, Scorecard)
// =============================================================================

function initQuizStudio(topic) {
    currentQuizTopic = topic;
    activeQuizData = topic.quizData || generateFallbackQuiz(topic.title);

    // Dynamic Quiz Header
    const quizBreadcrumb = document.getElementById("quiz-breadcrumb");
    const modCrumb = document.getElementById("quiz-module-crumb");
    const typeBadge = document.getElementById("quiz-type-badge");
    const crumbEl = document.getElementById("quiz-chapter-crumb");
    const titleEl = document.getElementById("quiz-title-display");
    const subtitleEl = document.getElementById("quiz-subtitle-display");
    const timerDisplay = document.getElementById("quiz-timer-display");

    if (quizBreadcrumb) {
        quizBreadcrumb.textContent = `${topic.moduleName || 'Module'} • ${topic.chapterName || 'Chapter'} • ${topic.quizType === 'chapter' ? 'Mastery Assessment' : 'Checkpoint Quiz'}`;
    }

    if (modCrumb) modCrumb.textContent = topic.moduleName || "Module";

    if (typeBadge) {
        if (topic.quizType === "chapter") {
            typeBadge.className = "badge bg-purple text-white fw-bold text-xs px-2.5 py-1";
            typeBadge.style.backgroundColor = "#7c3aed";
            typeBadge.innerHTML = `<i class="fa-solid fa-award me-1"></i> Chapter Assessment`;
        } else {
            typeBadge.className = "badge bg-warning text-dark fw-bold text-xs px-2.5 py-1";
            typeBadge.style.backgroundColor = "";
            typeBadge.innerHTML = `<i class="fa-solid fa-clipboard-question me-1"></i> Topic Quiz`;
        }
    }

    if (crumbEl) crumbEl.textContent = `${topic.chapterName || 'Chapter'} • Assessment`;
    if (titleEl) titleEl.textContent = activeQuizData.title || topic.title;
    if (subtitleEl) subtitleEl.textContent = activeQuizData.subtitle || "Single Best Answer Multiple Choice Questions.";

    const totalQuestions = activeQuizData.questions ? activeQuizData.questions.length : 0;
    const timeMins = activeQuizData.timeLimitMinutes || 5;
    if (timerDisplay) timerDisplay.textContent = formatTimerSeconds(timeMins * 60);

    // Switch to Start Screen
    const startScreen = document.getElementById("quiz-start-screen");
    const playerScreen = document.getElementById("quiz-player-screen");
    const scorecardScreen = document.getElementById("quiz-scorecard-screen");

    if (startScreen) startScreen.classList.remove("d-none");
    if (playerScreen) playerScreen.classList.add("d-none");
    if (scorecardScreen) scorecardScreen.classList.add("d-none");

    const statTotalQ = document.getElementById("quiz-stat-total-q");
    const statDuration = document.getElementById("quiz-stat-duration");
    const statPass = document.getElementById("quiz-stat-pass");

    if (statTotalQ) statTotalQ.textContent = `${totalQuestions} MCQs`;
    if (statDuration) statDuration.textContent = `${timeMins} Mins`;
    if (statPass) statPass.textContent = `${activeQuizData.passingScore || 80}%`;

    // Wire Start Quiz Button
    const startBtn = document.getElementById("start-quiz-btn");
    if (startBtn) {
        startBtn.onclick = () => startQuizSession();
    }
}

function startQuizSession() {
    if (!activeQuizData || !activeQuizData.questions || activeQuizData.questions.length === 0) return;

    const totalQuestions = activeQuizData.questions.length;
    userSelections = new Array(totalQuestions).fill(null);
    checkedStatus = new Array(totalQuestions).fill(false);
    currentQuestionIdx = 0;
    timeRemainingSec = (activeQuizData.timeLimitMinutes || 5) * 60;
    timeSpentSec = 0;

    // Switch to Active Question Player Screen
    const startScreen = document.getElementById("quiz-start-screen");
    const playerScreen = document.getElementById("quiz-player-screen");
    const scorecardScreen = document.getElementById("quiz-scorecard-screen");

    if (startScreen) startScreen.classList.add("d-none");
    if (playerScreen) playerScreen.classList.remove("d-none");
    if (scorecardScreen) scorecardScreen.classList.add("d-none");

    // Start Timer Interval
    if (quizTimerInterval) clearInterval(quizTimerInterval);
    const timerDisplay = document.getElementById("quiz-timer-display");

    quizTimerInterval = setInterval(() => {
        timeRemainingSec--;
        timeSpentSec++;

        if (timerDisplay) {
            timerDisplay.textContent = formatTimerSeconds(Math.max(0, timeRemainingSec));
        }

        if (timeRemainingSec <= 0) {
            clearInterval(quizTimerInterval);
            quizTimerInterval = null;
            alert("Time is up! Submitting your answers automatically.");
            submitQuizSession();
        }
    }, 1000);

    // Wire Player Control Buttons
    wireQuizPlayerControls();

    // Render Question
    loadQuizQuestion(0);
}

function wireQuizPlayerControls() {
    const prevBtn = document.getElementById("quiz-prev-btn");
    const checkBtn = document.getElementById("quiz-check-btn");
    const nextBtn = document.getElementById("quiz-next-btn");
    const finishBtn = document.getElementById("quiz-finish-btn");

    if (prevBtn) {
        prevBtn.onclick = () => {
            if (currentQuestionIdx > 0) {
                loadQuizQuestion(currentQuestionIdx - 1);
            }
        };
    }

    if (checkBtn) {
        checkBtn.onclick = () => {
            checkCurrentAnswer();
        };
    }

    if (nextBtn) {
        nextBtn.onclick = () => {
            if (currentQuestionIdx < activeQuizData.questions.length - 1) {
                loadQuizQuestion(currentQuestionIdx + 1);
            }
        };
    }

    if (finishBtn) {
        finishBtn.onclick = () => {
            submitQuizSession();
        };
    }
}

function loadQuizQuestion(qIdx) {
    currentQuestionIdx = qIdx;
    const questions = activeQuizData.questions;
    const total = questions.length;
    const currentQ = questions[qIdx];

    // Tracker label
    const qnumLabel = document.getElementById("quiz-qnum-label");
    if (qnumLabel) qnumLabel.textContent = `Question ${qIdx + 1} of ${total}`;

    // Navigator Dots
    renderQuizNavDots();

    // Question statement
    const stmtEl = document.getElementById("quiz-question-statement");
    if (stmtEl) stmtEl.textContent = currentQ.question;

    // Options Cards
    const optionsContainer = document.getElementById("quiz-options-container");
    if (optionsContainer) {
        optionsContainer.innerHTML = "";
        const letters = ["A", "B", "C", "D", "E"];
        const selectedOpt = userSelections[qIdx];
        const isChecked = checkedStatus[qIdx];

        currentQ.options.forEach((optText, optIdx) => {
            let cardClass = "quiz-option-card";
            if (selectedOpt === optIdx) {
                cardClass += " selected";
            }
            if (isChecked) {
                if (optIdx === currentQ.correctIndex) {
                    cardClass += " correct";
                } else if (selectedOpt === optIdx && optIdx !== currentQ.correctIndex) {
                    cardClass += " incorrect";
                }
            }

            const card = document.createElement("div");
            card.className = cardClass;
            card.dataset.optionIndex = optIdx;
            card.innerHTML = `
                <div class="quiz-option-letter">${letters[optIdx] || optIdx + 1}</div>
                <div class="flex-grow-1">${optText}</div>
            `;

            card.addEventListener("click", () => {
                if (!checkedStatus[currentQuestionIdx]) {
                    selectQuizOption(optIdx);
                }
            });

            optionsContainer.appendChild(card);
        });
    }

    // Explanation Box
    const explanationBox = document.getElementById("quiz-explanation-box");
    const explanationText = document.getElementById("quiz-explanation-text");
    if (explanationBox && explanationText) {
        if (checkedStatus[qIdx]) {
            explanationBox.classList.remove("d-none");
            explanationText.textContent = currentQ.explanation || "Correct option is verified according to the PMDC curriculum.";
        } else {
            explanationBox.classList.add("d-none");
        }
    }

    // Button states
    const prevBtn = document.getElementById("quiz-prev-btn");
    const checkBtn = document.getElementById("quiz-check-btn");
    const nextBtn = document.getElementById("quiz-next-btn");
    const finishBtn = document.getElementById("quiz-finish-btn");

    if (prevBtn) {
        prevBtn.disabled = (qIdx === 0);
    }

    if (checkBtn) {
        if (checkedStatus[qIdx]) {
            checkBtn.disabled = true;
            checkBtn.innerHTML = `<i class="fa-solid fa-check-double me-1"></i> Checked`;
        } else if (userSelections[qIdx] !== null) {
            checkBtn.disabled = false;
            checkBtn.innerHTML = `<i class="fa-solid fa-circle-check me-1"></i> Check Answer`;
        } else {
            checkBtn.disabled = true;
            checkBtn.innerHTML = `<i class="fa-solid fa-circle-check me-1"></i> Check Answer`;
        }
    }

    if (nextBtn && finishBtn) {
        if (qIdx === total - 1) {
            nextBtn.classList.add("d-none");
            finishBtn.classList.remove("d-none");
        } else {
            nextBtn.classList.remove("d-none");
            finishBtn.classList.add("d-none");
        }
    }
}

function renderQuizNavDots() {
    const dotsContainer = document.getElementById("quiz-nav-dots");
    if (!dotsContainer || !activeQuizData) return;
    dotsContainer.innerHTML = "";

    const questions = activeQuizData.questions;
    questions.forEach((q, i) => {
        const dot = document.createElement("div");
        let dotClass = "quiz-dot";

        if (i === currentQuestionIdx) {
            dotClass += " active";
        }
        if (checkedStatus[i]) {
            if (userSelections[i] === q.correctIndex) {
                dotClass += " correct";
            } else {
                dotClass += " wrong";
            }
        } else if (userSelections[i] !== null) {
            dotClass += " answered";
        }

        dot.className = dotClass;
        dot.textContent = i + 1;
        dot.title = `Jump to Question ${i + 1}`;
        dot.addEventListener("click", () => {
            loadQuizQuestion(i);
        });

        dotsContainer.appendChild(dot);
    });
}

function selectQuizOption(optIdx) {
    userSelections[currentQuestionIdx] = optIdx;
    loadQuizQuestion(currentQuestionIdx);
}

function checkCurrentAnswer() {
    if (userSelections[currentQuestionIdx] === null) return;
    checkedStatus[currentQuestionIdx] = true;
    loadQuizQuestion(currentQuestionIdx);
}

function submitQuizSession() {
    if (quizTimerInterval) {
        clearInterval(quizTimerInterval);
        quizTimerInterval = null;
    }

    const questions = activeQuizData.questions;
    const total = questions.length;
    let correctCount = 0;

    questions.forEach((q, i) => {
        if (userSelections[i] === q.correctIndex) {
            correctCount++;
        }
    });

    const percent = total > 0 ? Math.round((correctCount / total) * 100) : 0;
    const passThreshold = activeQuizData.passingScore || 80;
    const isPassed = percent >= passThreshold;

    // Mark completed in localStorage & update curriculum
    if (currentQuizTopic) {
        setItemCompleted(activeCourseId, currentQuizTopic.id, true);
    }

    // Switch to Scorecard Screen
    const startScreen = document.getElementById("quiz-start-screen");
    const playerScreen = document.getElementById("quiz-player-screen");
    const scorecardScreen = document.getElementById("quiz-scorecard-screen");

    if (startScreen) startScreen.classList.add("d-none");
    if (playerScreen) playerScreen.classList.add("d-none");
    if (scorecardScreen) scorecardScreen.classList.remove("d-none");

    const scoreBadge = document.getElementById("quiz-score-badge");
    const scorePercent = document.getElementById("quiz-score-percent");
    const scoreStatus = document.getElementById("quiz-score-status");
    const resultTitle = document.getElementById("quiz-result-title");
    const resultMsg = document.getElementById("quiz-result-msg");
    const scoreRatio = document.getElementById("quiz-score-ratio");
    const accuracyRatio = document.getElementById("quiz-accuracy-ratio");
    const timeSpentEl = document.getElementById("quiz-time-spent");

    if (scoreBadge) {
        scoreBadge.className = `quiz-score-badge ${isPassed ? 'passed' : 'failed'}`;
    }
    if (scorePercent) scorePercent.textContent = `${percent}%`;
    if (scoreStatus) scoreStatus.textContent = isPassed ? "PASSED" : "NEEDS REVIEW";

    if (resultTitle) {
        resultTitle.textContent = isPassed ? "Outstanding Performance!" : "Quiz Completed — Keep Practicing!";
    }
    if (resultMsg) {
        resultMsg.textContent = isPassed
            ? "Congratulations! You have demonstrated strong conceptual retention in this curriculum milestone."
            : "You can retake this checkpoint to reinforce high-yield concepts and achieve 80%+ mastery.";
    }

    if (scoreRatio) scoreRatio.textContent = `${correctCount}/${total}`;
    if (accuracyRatio) accuracyRatio.textContent = `${percent}%`;
    if (timeSpentEl) timeSpentEl.textContent = formatTimerSeconds(timeSpentSec);

    // Retake and Proceed buttons
    const retakeBtn = document.getElementById("quiz-retake-btn");
    if (retakeBtn) {
        retakeBtn.onclick = () => {
            startQuizSession();
        };
    }

    const proceedBtn = document.getElementById("quiz-proceed-btn");
    if (proceedBtn) {
        proceedBtn.onclick = () => {
            const db = getDb();
            const rawCourse = db[activeCourseId];
            if (!rawCourse) return;
            const modules = normalizeCourseContent(rawCourse);
            const allTopics = getAllCourseTopics(modules);
            const currentIdx = allTopics.findIndex(t => t.id === currentQuizTopic.id);

            if (currentIdx !== -1 && currentIdx < allTopics.length - 1) {
                selectActiveTopic(allTopics[currentIdx + 1].id);
            } else if (allTopics.length > 0) {
                selectActiveTopic(allTopics[0].id);
            }
            window.scrollTo({ top: 120, behavior: "smooth" });
        };
    }
}

function formatTimerSeconds(totalSeconds) {
    const mins = Math.floor(totalSeconds / 60);
    const secs = totalSeconds % 60;
    return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
}

// =============================================================================
// 6. GENERAL LMS UI CONTROLLERS (Progress, Tabs, Q&A, Notes)
// =============================================================================

function updateCompleteButtonUi(isCompleted) {
    const btn = document.getElementById("complete-lesson-btn");
    if (!btn) return;
    if (isCompleted) {
        btn.innerHTML = `<i class="fa-solid fa-circle-check me-1.5"></i> Completed`;
        btn.className = "btn btn-sm btn-success text-white border-0 fw-semibold px-3 py-1.5 rounded-pill";
    } else {
        btn.innerHTML = `<i class="fa-regular fa-circle-check me-1.5"></i> Mark Complete`;
        btn.className = "btn btn-sm btn-outline-primary fw-semibold px-3 py-1.5 rounded-pill";
    }
}

function updateProgressUi() {
    const db = getDb();
    const rawCourse = db[activeCourseId];
    if (!rawCourse) return;

    const modules = normalizeCourseContent(rawCourse);
    const allTopics = getAllCourseTopics(modules);
    const totalItems = allTopics.length;

    const completedList = getCompletedItems(activeCourseId);
    const completedCount = completedList.length;
    const progressPercent = totalItems > 0 ? Math.round((completedCount / totalItems) * 100) : 0;

    const percentEl = document.getElementById("progress-percent");
    const ratioEl = document.getElementById("progress-ratio");
    const barEl = document.getElementById("study-progress-bar");

    if (percentEl) percentEl.textContent = `${progressPercent}%`;
    if (ratioEl) ratioEl.textContent = `${completedCount}/${totalItems} Lessons`;
    if (barEl) barEl.style.width = `${progressPercent}%`;
}

function updateSidebarCheckmarks() {
    const completedList = getCompletedItems(activeCourseId);
    document.querySelectorAll(".topic-row, .topic-study-item, .lesson-study-item").forEach(item => {
        const itemId = item.id.replace("item-", "");
        if (completedList.includes(itemId)) {
            item.classList.add("completed");
        } else {
            item.classList.remove("completed");
        }
    });
}

function renderQaFeed() {
    const feedContainer = document.getElementById("qa-thread-feed");
    if (!feedContainer) return;
    feedContainer.innerHTML = "";

    const db = getDb();
    const course = db[activeCourseId];

    // Pinned Instructor Announcement
    if (course && course.pinnedMessage) {
        const pinnedHtml = `
            <div class="p-3 mb-3 rounded-3 border bg-light qa-thread-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <img src="${getInstructorImage()}" alt="instructor" class="rounded-circle border" style="width: 38px; height: 38px; object-fit: cover;">
                        <div>
                            <span class="fw-bold text-dark text-sm d-inline-flex align-items-center">DoctorsInn Faculty <span class="badge bg-primary text-white text-xs px-2 py-0.5 ms-2 rounded-pill"><i class="fa-solid fa-thumbtack me-1"></i> Pinned Announcement</span></span>
                            <span class="text-xs text-muted d-block">Lead Medical Faculty</span>
                        </div>
                    </div>
                    <span class="text-xs text-muted font-semibold"><i class="fa-solid fa-shield-check text-primary me-1"></i> Verified</span>
                </div>
                <p class="mb-0 text-sm text-dark">${course.pinnedMessage}</p>
            </div>
        `;
        feedContainer.insertAdjacentHTML("beforeend", pinnedHtml);
    }

    const threads = getTopicQa(activeTopicId);
    if (threads.length === 0 && (!course || !course.pinnedMessage)) {
        feedContainer.innerHTML = `
            <div class="text-center py-4 text-muted text-sm">
                <i class="fa-regular fa-comments mb-2 d-block fs-3"></i>
                No questions asked yet. Be the first to ask!
            </div>
        `;
        return;
    }

    threads.forEach(post => {
        const isInstructor = post.role === "Instructor";
        const avatar = isInstructor ? getInstructorImage() : getStudentAvatar(post.avatar);
        const roleBadge = isInstructor ? `<span class="badge bg-primary text-white text-xs px-2 py-0.5 ms-2 rounded-pill">Instructor</span>` : "";

        const postHtml = `
            <div class="p-3 mb-3 rounded-3 border bg-white shadow-sm qa-thread-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <img src="${avatar}" alt="user" class="rounded-circle border" style="width: 36px; height: 36px; object-fit: cover;">
                        <div>
                            <span class="fw-bold text-dark text-sm d-inline-flex align-items-center">${post.user} ${roleBadge}</span>
                            <span class="text-xs text-muted d-block">${post.role}</span>
                        </div>
                    </div>
                    <span class="text-xs text-muted">${post.date}</span>
                </div>
                <p class="mb-0 text-sm text-secondary">${post.text}</p>
            </div>
        `;
        feedContainer.insertAdjacentHTML("beforeend", postHtml);
    });
}

// =============================================================================
// 7. INITIALIZATION
// =============================================================================

function initStudyPortal() {
    activeCourseId = getActiveCourseId();
    const db = getDb();
    const course = db[activeCourseId];

    if (course) {
        const bannerTitle = document.getElementById("course-title-banner");
        const breadcrumbName = document.getElementById("course-breadcrumb-name");
        if (bannerTitle) bannerTitle.textContent = course.title;
        if (breadcrumbName) breadcrumbName.textContent = course.title;

        // Course dropdown switcher
        const courseSelect = document.getElementById("enrolledCourseSelect");
        if (courseSelect) {
            courseSelect.value = activeCourseId;
            courseSelect.addEventListener("change", () => {
                const courseUrl = new URL(courseSelect.dataset.courseUrl || window.location.href, window.location.origin);
                courseUrl.searchParams.set("course", courseSelect.value);
                window.location.href = courseUrl.toString();
            });
        }

        const modules = normalizeCourseContent(course);

        // Find initial active topic
        if (modules.length > 0 && modules[0].chapters.length > 0 && modules[0].chapters[0].topics.length > 0) {
            activeTopicId = modules[0].chapters[0].topics[0].id;
        }
    }

    // Render Outline
    renderCurriculumSidebar();

    // Select Initial Topic
    if (activeTopicId) {
        selectActiveTopic(activeTopicId);
    }
    updateProgressUi();

    // Mark Complete Button
    const completeBtn = document.getElementById("complete-lesson-btn");
    if (completeBtn && !completeBtn._hasStudyListener) {
        completeBtn._hasStudyListener = true;
        completeBtn.addEventListener("click", () => {
            const completedList = getCompletedItems(activeCourseId);
            const isCompleted = completedList.includes(activeTopicId);
            setItemCompleted(activeCourseId, activeTopicId, !isCompleted);
            updateCompleteButtonUi(!isCompleted);
        });
    }

    // Personal Notes
    const saveNotesBtn = document.getElementById("save-notes-btn");
    const notesTextarea = document.getElementById("lesson-notes-textarea");
    if (saveNotesBtn && notesTextarea && !saveNotesBtn._hasStudyListener) {
        saveNotesBtn._hasStudyListener = true;
        saveNotesBtn.addEventListener("click", () => {
            saveTopicNotes(activeTopicId, notesTextarea.value);
            const saveStatus = document.getElementById("notes-save-status");
            if (saveStatus) {
                saveStatus.classList.remove("d-none");
                setTimeout(() => saveStatus.classList.add("d-none"), 2000);
            }
        });

        let autoSaveTimeout = null;
        notesTextarea.addEventListener("input", () => {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                saveTopicNotes(activeTopicId, notesTextarea.value);
                const saveStatus = document.getElementById("notes-save-status");
                if (saveStatus) {
                    saveStatus.classList.remove("d-none");
                    setTimeout(() => saveStatus.classList.add("d-none"), 1000);
                }
            }, 1200);
        });
    }

    // Q&A form submission
    const qaForm = document.getElementById("qa-form");
    const qaInput = document.getElementById("qa-input-text");
    if (qaForm && qaInput && !qaForm._hasStudyListener) {
        qaForm._hasStudyListener = true;
        qaForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const text = qaInput.value.trim();
            if (!text) return;

            let thread = getTopicQa(activeTopicId);
            thread.push({
                user: "Ahmed Khan",
                role: "Student",
                avatar: getStudentAvatar(),
                date: "Just now",
                text: text
            });

            saveTopicQa(activeTopicId, thread);
            renderQaFeed();
            qaInput.value = "";
        });
    }

    // Video security controls
    const videoElement = document.getElementById("main-video-player");
    if (videoElement) {
        videoElement.setAttribute("controlslist", "nodownload");
        videoElement.addEventListener("contextmenu", (e) => {
            e.preventDefault();
            return false;
        });
    }
}

// Auto-run on DOM ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initStudyPortal);
} else {
    initStudyPortal();
}
