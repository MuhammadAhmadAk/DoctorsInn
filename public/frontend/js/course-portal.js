/**
 * Course Study Portal Controller
 * DoctorsInnElite - Learning Portal
 * File: public/frontend/js/course-portal.js
 */

// Global database reference (loaded from my-courses-data.js)
const getDb = () => (typeof myCoursesData !== 'undefined' ? myCoursesData : (typeof coursesDatabase !== 'undefined' ? coursesDatabase : {}));

// State variables
let activeCourseId = "mdcat-reboot-60-day";
let activeLessonId = "";

// Helper Functions for URL & State
function getActiveCourseId() {
    const db = getDb();
    const urlParams = new URLSearchParams(window.location.search);
    let courseId = urlParams.get("course");

    if (!courseId) {
        const pathParts = window.location.pathname.split('/').filter(Boolean);
        const studyIdx = pathParts.findIndex(p => p === "my-courses");
        if (studyIdx !== -1 && pathParts[studyIdx + 1]) {
            courseId = pathParts[studyIdx + 1];
        }
    }

    if (courseId && db[courseId]) {
        return courseId;
    }

    // Default to first available or mdcat-reboot
    const keys = Object.keys(db);
    return keys.length > 0 ? (db["mdcat-reboot-60-day"] ? "mdcat-reboot-60-day" : keys[0]) : "mdcat-reboot-60-day";
}

// Completed Lessons in LocalStorage
function getCompletedLessons(courseId) {
    const key = `completed_lessons_${courseId}`;
    try {
        const completed = localStorage.getItem(key);
        return completed ? JSON.parse(completed) : [];
    } catch (e) {
        return [];
    }
}

function setLessonCompleted(courseId, lessonId, isCompleted) {
    const key = `completed_lessons_${courseId}`;
    let completed = getCompletedLessons(courseId);

    if (isCompleted) {
        if (!completed.includes(lessonId)) {
            completed.push(lessonId);
        }
    } else {
        completed = completed.filter(id => id !== lessonId);
    }

    localStorage.setItem(key, JSON.stringify(completed));
    updateProgressUi();
    updateSidebarCheckmarks();
}

// Notes Storage
function getLessonNotes(lessonId) {
    return localStorage.getItem(`notes_${lessonId}`) || "";
}

function saveLessonNotes(lessonId, content) {
    localStorage.setItem(`notes_${lessonId}`, content);
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

// Q&A Store
function getLessonQa(lessonId) {
    const key = `qa_${lessonId}`;
    try {
        const qa = localStorage.getItem(key);
        return qa ? JSON.parse(qa) : [
            {
                user: "Ali Hassan",
                role: "Student",
                avatar: getStudentAvatar(),
                date: "3 hours ago",
                text: "Is this lesson strictly aligned with the updated PMDC syllabus for the upcoming exam session?"
            },
            {
                user: "DoctorsInn Mentor",
                role: "Instructor",
                avatar: getInstructorImage(),
                date: "2 hours ago",
                text: "Yes, Ali! All topics, MCQs, and past questions are 100% mapped to the official MDCAT syllabus."
            }
        ];
    } catch (e) {
        return [];
    }
}

function saveLessonQa(lessonId, thread) {
    localStorage.setItem(`qa_${lessonId}`, JSON.stringify(thread));
}

// --- UI Rendering ---
function renderSyllabusSidebar() {
    const db = getDb();
    const course = db[activeCourseId];
    if (!course || !course.modules) return;

    const accordionContainer = document.getElementById("syllabusAccordion");
    if (!accordionContainer) return;
    accordionContainer.innerHTML = "";
    if (!accordionContainer._hasLessonListener) {
        accordionContainer._hasLessonListener = true;
        accordionContainer.addEventListener("click", event => {
            const lessonItem = event.target.closest("[data-lesson-id]");
            if (lessonItem) selectActiveLesson(lessonItem.dataset.lessonId);
        });
    }

    course.modules.forEach((module, moduleIdx) => {
        const accordionId = `moduleCollapse_${moduleIdx}`;
        const isShow = moduleIdx === 0 ? "show" : "";
        const isExpanded = moduleIdx === 0 ? "true" : "false";
        const buttonCollapsed = moduleIdx === 0 ? "" : "collapsed";

        let lessonsHtml = "";
        module.lessons.forEach(lesson => {
            const iconClass = lesson.type === "video" ? "fa-regular fa-video" : "fa-regular fa-file-lines";
            const completedList = getCompletedLessons(activeCourseId);
            const isCompleted = completedList.includes(lesson.id);
            const completedClass = isCompleted ? "completed" : "";
            const activeClass = lesson.id === activeLessonId ? "active" : "";

            lessonsHtml += `
                <div class="lesson-study-item ${activeClass} ${completedClass}" id="item-${lesson.id}" data-lesson-id="${lesson.id}">
                    <span class="lesson-icon-wrapper">
                        <i class="${iconClass}"></i>
                    </span>
                    <div class="lesson-meta-info flex-grow-1">
                        <span class="lesson-title-text">${lesson.title}</span>
                        <span class="lesson-time text-muted text-xs">${lesson.duration}</span>
                    </div>
                    <span class="status-indicator">
                        <i class="fa-solid fa-circle-check checkmark"></i>
                        <i class="fa-regular fa-circle bullet"></i>
                    </span>
                </div>
            `;
        });

        const moduleCardHtml = `
            <div class="accordion-item study-accordion-item">
                <h2 class="accordion-header" id="heading_${moduleIdx}">
                    <button class="accordion-button ${buttonCollapsed}" type="button" data-bs-toggle="collapse" data-bs-target="#${accordionId}" aria-expanded="${isExpanded}" aria-controls="${accordionId}">
                        <div class="d-flex flex-column text-start">
                            <span class="fw-bold text-title text-sm">${module.name}</span>
                            <span class="text-xs text-muted mt-1">${module.lessons.length} Lessons</span>
                        </div>
                    </button>
                </h2>
                <div id="${accordionId}" class="accordion-collapse collapse ${isShow}" aria-labelledby="heading_${moduleIdx}" data-bs-parent="#syllabusAccordion">
                    <div class="accordion-body p-2 study-accordion-body">
                        ${lessonsHtml}
                    </div>
                </div>
            </div>
        `;
        accordionContainer.insertAdjacentHTML("beforeend", moduleCardHtml);
    });
}

function selectActiveLesson(lessonId) {
    activeLessonId = lessonId;

    const db = getDb();
    const course = db[activeCourseId];
    if (!course || !course.modules) return;

    let activeLesson = null;
    let parentModuleName = "Course Module";

    course.modules.forEach(module => {
        module.lessons.forEach(lesson => {
            if (lesson.id === lessonId) {
                activeLesson = lesson;
                parentModuleName = module.name;
            }
        });
    });

    if (!activeLesson) return;

    // Highlight active in sidebar
    document.querySelectorAll(".lesson-study-item").forEach(item => {
        item.classList.remove("active");
    });
    const sidebarItem = document.getElementById(`item-${lessonId}`);
    if (sidebarItem) {
        sidebarItem.classList.add("active");
    }

    // Video vs Text
    const videoContainer = document.getElementById("video-player-container");
    const textBanner = document.getElementById("text-lesson-banner");
    const videoPlayer = document.getElementById("main-video-player");

    if (activeLesson.type === "video" && activeLesson.videoUrl) {
        if (videoContainer) videoContainer.classList.remove("d-none");
        if (textBanner) textBanner.classList.add("d-none");
        if (videoPlayer) {
            videoPlayer.src = activeLesson.videoUrl;
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
        if (textBannerTitle) textBannerTitle.textContent = activeLesson.title;
    }

    // Labels
    const moduleNameEl = document.getElementById("active-module-name");
    const lessonTitleEl = document.getElementById("active-lesson-title");
    const lessonDurationEl = document.getElementById("active-lesson-duration");
    const lessonTypeEl = document.getElementById("active-lesson-type");

    if (moduleNameEl) moduleNameEl.textContent = parentModuleName;
    if (lessonTitleEl) lessonTitleEl.textContent = activeLesson.title;
    if (lessonDurationEl) lessonDurationEl.textContent = activeLesson.duration;
    if (lessonTypeEl) lessonTypeEl.textContent = activeLesson.type === "video" ? "Video Lecture" : "Read Article / Exam";

    // Mark complete button toggle
    const completedList = getCompletedLessons(activeCourseId);
    const isCompleted = completedList.includes(lessonId);
    updateCompleteButtonUi(isCompleted);

    // Reading text content
    const readingBody = document.getElementById("lesson-reading-body");
    if (readingBody) {
        readingBody.innerHTML = activeLesson.readContent || "<p class='p-3 text-muted'>Lecture content is being updated by instructors.</p>";
    }

    // Notes
    const notesTextarea = document.getElementById("lesson-notes-textarea");
    if (notesTextarea) {
        notesTextarea.value = getLessonNotes(lessonId);
    }
    const notesStatus = document.getElementById("notes-save-status");
    if (notesStatus) notesStatus.classList.add("d-none");

    // Resources Tab
    const resourcesContainer = document.getElementById("lesson-resources-list");
    if (resourcesContainer) {
        resourcesContainer.innerHTML = "";
        if (!resourcesContainer._hasDownloadListener) {
            resourcesContainer._hasDownloadListener = true;
            resourcesContainer.addEventListener("click", event => {
                const downloadButton = event.target.closest("[data-resource-download]");
                if (!downloadButton) return;
                downloadResourceFile(downloadButton.dataset.resourceDownload);
            });
        }
        const allResources = (activeLesson.resources && activeLesson.resources.length > 0)
            ? activeLesson.resources
            : (course.defaultResources || []);

        if (allResources && allResources.length > 0) {
            allResources.forEach(res => {
                const resHtml = `
                    <div class="resource-study-box d-flex align-items-center justify-content-between p-3 mb-2 rounded-3 border study-resource-box">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 p-2 d-flex align-items-center justify-content-center study-resource-icon">
                                <i class="fa-solid fa-file-pdf text-danger study-resource-file-icon"></i>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-title text-sm">${res.name}</span>
                                <span class="text-xs text-muted"><i class="fa-regular fa-download me-1"></i> Verified MDCAT Study Resource &bull; PDF Document</span>
                            </div>
                        </div>
                        <button type="button" data-resource-download="${res.name}" class="th-btn btn-sm py-2 px-3 study-resource-download">
                            <i class="fa-regular fa-arrow-down-to-line me-1"></i> Download PDF
                        </button>
                    </div>
                `;
                resourcesContainer.insertAdjacentHTML("beforeend", resHtml);
            });
        } else {
            resourcesContainer.innerHTML = `
                <div class="text-center py-4 text-muted text-sm">
                    <i class="fa-regular fa-folder-open mb-2 d-block study-empty-icon"></i>
                    No additional resources attached for this lesson.
                </div>
            `;
        }
    }

    // Q&A
    renderQaFeed();
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

function updateCompleteButtonUi(isCompleted) {
    const btn = document.getElementById("complete-lesson-btn");
    if (!btn) return;
    if (isCompleted) {
        btn.innerHTML = `<i class="fa-solid fa-circle-check me-2"></i> Completed`;
        btn.className = "th-btn btn-sm bg-success text-white border-0";
    } else {
        btn.innerHTML = `<i class="fa-regular fa-circle-check me-2"></i> Mark Complete`;
        btn.className = "th-btn btn-sm";
    }
}

function updateProgressUi() {
    const db = getDb();
    const course = db[activeCourseId];
    if (!course || !course.modules) return;

    let totalLessons = 0;
    course.modules.forEach(module => {
        totalLessons += module.lessons.length;
    });

    const completedList = getCompletedLessons(activeCourseId);
    const completedCount = completedList.length;
    const progressPercent = totalLessons > 0 ? Math.round((completedCount / totalLessons) * 100) : 0;

    const percentEl = document.getElementById("progress-percent");
    const ratioEl = document.getElementById("progress-ratio");
    const barEl = document.getElementById("study-progress-bar");

    if (percentEl) percentEl.textContent = `${progressPercent}% Completed`;
    if (ratioEl) ratioEl.textContent = `${completedCount}/${totalLessons} Lessons`;
    if (barEl) barEl.style.width = `${progressPercent}%`;
}

function updateSidebarCheckmarks() {
    const completedList = getCompletedLessons(activeCourseId);
    document.querySelectorAll(".lesson-study-item").forEach(item => {
        const lessonId = item.id.replace("item-", "");
        if (completedList.includes(lessonId)) {
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
            <div class="p-3 mb-3 rounded-3 border qa-thread-card qa-thread-instructor qa-pinned-announcement">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <img src="${getInstructorImage()}" alt="instructor" class="rounded-circle border qa-user-avatar qa-instructor-avatar">
                        <div>
                            <span class="fw-bold text-title text-sm d-inline-flex align-items-center">DoctorsInn Faculty <span class="badge bg-primary text-white text-xs px-2 py-1 radius-4 ms-2"><i class="fa-solid fa-thumbtack me-1"></i> Pinned Announcement</span></span>
                            <span class="text-xs text-muted d-block">Lead Medical Instructor</span>
                        </div>
                    </div>
                    <span class="text-xs text-muted font-semibold"><i class="fa-solid fa-shield-check text-primary me-1"></i> Verified</span>
                </div>
                <p class="mb-0 text-sm qa-pinned-message">${course.pinnedMessage}</p>
            </div>
        `;
        feedContainer.insertAdjacentHTML("beforeend", pinnedHtml);
    }

    const threads = getLessonQa(activeLessonId);
    if (threads.length === 0 && (!course || !course.pinnedMessage)) {
        feedContainer.innerHTML = `
            <div class="text-center py-4 text-muted text-sm">
                <i class="fa-regular fa-comments mb-2 d-block study-empty-icon"></i>
                No questions asked yet. Be the first to ask!
            </div>
        `;
        return;
    }

    threads.forEach(post => {
        const isInstructor = post.role === "Instructor";
        const avatar = isInstructor ? getInstructorImage() : getStudentAvatar(post.avatar);
        const roleBadge = isInstructor ? `<span class="badge bg-primary text-white text-xs px-2 py-1 radius-4 ms-2">Instructor</span>` : "";
        const authorClass = isInstructor ? "qa-thread-instructor" : "qa-thread-student";

        const postHtml = `
            <div class="p-3 mb-3 rounded-3 border qa-thread-card ${authorClass}">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <img src="${avatar}" alt="user" class="rounded-circle border qa-user-avatar">
                        <div>
                            <span class="fw-bold text-title text-sm d-inline-flex align-items-center">${post.user} ${roleBadge}</span>
                            <span class="text-xs text-muted d-block">${post.role}</span>
                        </div>
                    </div>
                    <span class="text-xs text-muted">${post.date}</span>
                </div>
                <p class="mb-0 text-sm text-secondary-color qa-thread-message">${post.text}</p>
            </div>
        `;
        feedContainer.insertAdjacentHTML("beforeend", postHtml);
    });
}

// Main Initialization Function
function initStudyPortal() {
    activeCourseId = getActiveCourseId();
    const db = getDb();
    const course = db[activeCourseId];

    if (course) {
        const bannerTitle = document.getElementById("course-title-banner");
        const breadcrumbName = document.getElementById("course-breadcrumb-name");
        if (bannerTitle) bannerTitle.textContent = course.title;
        if (breadcrumbName) breadcrumbName.textContent = course.title;

        // Set course dropdown if exists
        const courseSelect = document.getElementById("enrolledCourseSelect");
        if (courseSelect) {
            courseSelect.value = activeCourseId;
            courseSelect.addEventListener("change", () => {
                const courseUrl = new URL(courseSelect.dataset.courseUrl, window.location.origin);
                courseUrl.searchParams.set("course", courseSelect.value);
                window.location.href = courseUrl.toString();
            });
        }

        if (course.modules && course.modules.length > 0 && course.modules[0].lessons.length > 0) {
            activeLessonId = course.modules[0].lessons[0].id;
        }
    }

    renderSyllabusSidebar();
    if (activeLessonId) {
        selectActiveLesson(activeLessonId);
    }
    updateProgressUi();

    // Bind Mark Complete
    const completeBtn = document.getElementById("complete-lesson-btn");
    if (completeBtn && !completeBtn._hasStudyListener) {
        completeBtn._hasStudyListener = true;
        completeBtn.addEventListener("click", () => {
            const completedList = getCompletedLessons(activeCourseId);
            const isCompleted = completedList.includes(activeLessonId);
            setLessonCompleted(activeCourseId, activeLessonId, !isCompleted);
            updateCompleteButtonUi(!isCompleted);
        });
    }

    // Bind Notes
    const saveNotesBtn = document.getElementById("save-notes-btn");
    const notesTextarea = document.getElementById("lesson-notes-textarea");
    if (saveNotesBtn && notesTextarea && !saveNotesBtn._hasStudyListener) {
        saveNotesBtn._hasStudyListener = true;
        saveNotesBtn.addEventListener("click", () => {
            saveLessonNotes(activeLessonId, notesTextarea.value);
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
                saveLessonNotes(activeLessonId, notesTextarea.value);
                const saveStatus = document.getElementById("notes-save-status");
                if (saveStatus) {
                    saveStatus.classList.remove("d-none");
                    setTimeout(() => saveStatus.classList.add("d-none"), 1000);
                }
            }, 1200);
        });
    }

    // Bind Q&A form
    const qaForm = document.getElementById("qa-form");
    const qaInput = document.getElementById("qa-input-text");
    if (qaForm && qaInput && !qaForm._hasStudyListener) {
        qaForm._hasStudyListener = true;
        qaForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const text = qaInput.value.trim();
            if (!text) return;

            let thread = getLessonQa(activeLessonId);
            thread.push({
                user: "Ahmed Khan",
                role: "Student",
                avatar: getStudentAvatar(),
                date: "Just now",
                text: text
            });

            saveLessonQa(activeLessonId, thread);
            renderQaFeed();
            qaInput.value = "";
        });
    }

    // Video security
    const videoElement = document.getElementById("main-video-player");
    if (videoElement) {
        videoElement.setAttribute("controlslist", "nodownload");
        videoElement.addEventListener("contextmenu", (e) => {
            e.preventDefault();
            return false;
        });
    }
}

// Auto-run on DOM ready or immediately if already loaded
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initStudyPortal);
} else {
    initStudyPortal();
}