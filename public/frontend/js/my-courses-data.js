/**
 * =========================================================================
 * DoctorsInnElite - My Courses Learning Content Database
 * File: public/frontend/js/my-courses-data.js
 * 
 * 💡 EDITING GUIDE:
 * - Har course ka content is file mein structured tareeqe se likha hua hai.
 * - Aap kisi bhi lesson ka title, reading notes, videoUrl, resources (PDF),
 *   ya Q&A pinned message yahan easily edit/add kar sakte hain.
 * =========================================================================
 */

const myCoursesData = {
    // =========================================================================
    // 🎓 COURSE 1: MDCAT Reboot: 60-Day Preparation Program
    // =========================================================================
    "mdcat-reboot-60-day": {
        id: "mdcat-reboot-60-day",
        title: "MDCAT Reboot: 60-Day Preparation Program",
        description: "Complete 60-day intensive MDCAT preparation program covering complete PMDC syllabus with topic-wise lessons and mocks.",
        pinnedMessage: "Welcome to MDCAT Reboot! Post your questions here and our instructors will respond within 24 hours. You can also help fellow students by answering their queries.",
        defaultResources: [
            { name: "Biology Chapter Notes — PDF", type: "pdf" },
            { name: "Chemistry Formula Sheet — PDF", type: "pdf" },
            { name: "Physics Revision Notes — PDF", type: "pdf" },
            { name: "60-Day Study Plan — PDF", type: "pdf" },
            { name: "Mock Test Answer Keys — PDF", type: "pdf" }
        ],
        modules: [
            {
                name: "Module 1: Biology",
                lessons: [
                    {
                        id: "reboot-bio-1",
                        title: "Lesson 1 — Cell Biology & Cell Division",
                        type: "video",
                        duration: "45 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Biology &bull; Core Module</span>
                                <h3 class="fw-bold text-title">Lesson 1: Cell Biology & Cell Division</h3>
                            </div>
                            <div class="alert alert-primary bg-light border-primary p-3 rounded-3 mb-4">
                                <p class="mb-0 text-dark"><strong>Summary:</strong> In this lesson you will cover the complete MDCAT syllabus on Cell Biology including cell structure, organelles, mitosis, meiosis, and their exam-relevant MCQs. Watch the video lecture, read the notes, and attempt practice questions at the end.</p>
                            </div>

                            <h4>1. Cell Structure & Major Organelles</h4>
                            <p>Cells represent the structural and functional units of living systems. For MDCAT examinations, questions primarily test differences between prokaryotic and eukaryotic architectures:</p>
                            <ul>
                                <li><strong>Plasma Membrane:</strong> Fluid Mosaic Model by Singer & Nicolson. Lipid bilayer with amphipathic phospholipids and embedded proteins. Cholesterol provides fluidity buffer.</li>
                                <li><strong>Mitochondria:</strong> Powerhouse of the cell with circular DNA and 70S ribosomes. Inner membrane invaginations (cristae) host Electron Transport Chain complexes and ATP Synthase (F0-F1 particles).</li>
                                <li><strong>Endoplasmic Reticulum:</strong> RER is studded with 80S ribosomes for secretable protein synthesis; SER synthesizes steroids, phospholipids, and detoxifies xenobiotics.</li>
                                <li><strong>Golgi Complex:</strong> Polarized cisternae (cis-face forming, trans-face maturing) responsible for glycosylation and lysosome generation.</li>
                            </ul>

                            <h4 class="mt-4">2. Cell Division — Mitosis vs Meiosis Comparison</h4>
                            <div class="table-responsive my-3">
                                <table class="table table-bordered text-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Feature</th>
                                            <th>Mitosis (Equational)</th>
                                            <th>Meiosis (Reductional)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Occurs In</strong></td>
                                            <td>Somatic cells</td>
                                            <td>Germ line cells (gametogenesis)</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Daughter Cells</strong></td>
                                            <td>2 identical diploid (2n) cells</td>
                                            <td>4 genetically distinct haploid (1n) cells</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Genetic Recombination</strong></td>
                                            <td>Absent</td>
                                            <td>Present during Pachytene stage of Prophase I</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h4 class="mt-4">3. Exam-Relevant High-Yield MCQs</h4>
                            <div class="p-3 bg-light rounded-3 border mb-3">
                                <p class="fw-bold mb-1">Q: Crossing over between non-sister chromatids occurs during which phase?</p>
                                <p class="text-muted mb-1">A) Leptotene &nbsp;|&nbsp; B) Zygotene &nbsp;|&nbsp; <strong>C) Pachytene (Correct)</strong> &nbsp;|&nbsp; D) Diplotene</p>
                                <small class="text-success"><i class="fa-solid fa-check me-1"></i> Explanation: Synapsis completes at Zygotene, followed by crossing over at Pachytene via recombination nodules.</small>
                            </div>
                        `,
                        resources: [
                            { name: "Biology Chapter Notes — PDF", type: "pdf" },
                            { name: "60-Day Study Plan — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "reboot-bio-2",
                        title: "Lesson 2 — Genetics & Inheritance",
                        type: "video",
                        duration: "50 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Biology &bull; Genetics</span>
                                <h3 class="fw-bold text-title">Lesson 2: Genetics & Inheritance</h3>
                            </div>
                            <p>Mendelian genetics, laws of segregation, independent assortment, sex-linked traits, and gene interaction patterns.</p>
                            <h5>Key Highlights:</h5>
                            <ul>
                                <li><strong>Monohybrid Cross:</strong> Phenotypic ratio 3:1, genotypic ratio 1:2:1.</li>
                                <li><strong>Dihybrid Cross:</strong> 9:3:3:1 phenotypic ratio assuming unlinked loci.</li>
                                <li><strong>X-Linked Recessive:</strong> Hemophilia and Color Blindness, criss-cross inheritance from grandfather to grandson via carrier daughter.</li>
                            </ul>
                        `,
                        resources: [
                            { name: "Biology Chapter Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "reboot-bio-3",
                        title: "Lesson 3 — Biological Molecules",
                        type: "text",
                        duration: "35 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Biology &bull; Biochemistry</span>
                                <h3 class="fw-bold text-title">Lesson 3: Biological Molecules</h3>
                            </div>
                            <p>Study of carbohydrates, proteins, lipids, nucleic acids, and enzymatic mechanisms under physiological conditions.</p>
                        `,
                        resources: [
                            { name: "Biology Chapter Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "reboot-bio-4",
                        title: "Lesson 4 — Kingdom Animalia & Plantae",
                        type: "video",
                        duration: "40 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Biology &bull; Diversity</span>
                                <h3 class="fw-bold text-title">Lesson 4: Kingdom Animalia & Plantae</h3>
                            </div>
                            <p>Evolutionary trends in invertebrates and vertebrates, coelom organization, symmetry, and plant alternation of generations.</p>
                        `,
                        resources: [
                            { name: "Biology Chapter Notes — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Module 2: Chemistry",
                lessons: [
                    {
                        id: "reboot-chem-5",
                        title: "Lesson 5 — Organic Chemistry Basics",
                        type: "video",
                        duration: "55 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-success text-white px-3 py-1 rounded-pill mb-2">Chemistry &bull; Organic</span>
                                <h3 class="fw-bold text-title">Lesson 5: Organic Chemistry Basics</h3>
                            </div>
                            <p>IUPAC Nomenclature, structural and stereoisomerism, inductive effect, resonance, and carbocation stability.</p>
                        `,
                        resources: [
                            { name: "Chemistry Formula Sheet — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "reboot-chem-6",
                        title: "Lesson 6 — Chemical Bonding",
                        type: "text",
                        duration: "40 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-success text-white px-3 py-1 rounded-pill mb-2">Chemistry &bull; Physical</span>
                                <h3 class="fw-bold text-title">Lesson 6: Chemical Bonding</h3>
                            </div>
                            <p>VSEPR theory, hybridization (sp3, sp2, sp), bond parameters, dipole moment, and intermolecular interactions.</p>
                        `,
                        resources: [
                            { name: "Chemistry Formula Sheet — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "reboot-chem-7",
                        title: "Lesson 7 — Reaction Kinetics",
                        type: "video",
                        duration: "45 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-success text-white px-3 py-1 rounded-pill mb-2">Chemistry &bull; Physical</span>
                                <h3 class="fw-bold text-title">Lesson 7: Reaction Kinetics</h3>
                            </div>
                            <p>Rate of reaction, differential rate equations, order of reaction, Arrhenius activation energy, and catalyst action.</p>
                        `,
                        resources: [
                            { name: "Chemistry Formula Sheet — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Module 3: Physics",
                lessons: [
                    {
                        id: "reboot-phy-8",
                        title: "Lesson 8 — Mechanics & Motion",
                        type: "video",
                        duration: "50 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill mb-2">Physics &bull; Mechanics</span>
                                <h3 class="fw-bold text-title">Lesson 8: Mechanics & Motion</h3>
                            </div>
                            <p>Linear motion, projectile trajectories, Newton's laws, impulse, conservation of momentum, and work-energy theorem.</p>
                        `,
                        resources: [
                            { name: "Physics Revision Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "reboot-phy-9",
                        title: "Lesson 9 — Waves & Electricity",
                        type: "video",
                        duration: "45 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill mb-2">Physics &bull; Electricity</span>
                                <h3 class="fw-bold text-title">Lesson 9: Waves & Electricity</h3>
                            </div>
                            <p>Simple Harmonic Motion, standing waves, Doppler effect, Coulomb's law, Ohm's law, and Kirchhoff's loop analysis.</p>
                        `,
                        resources: [
                            { name: "Physics Revision Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "reboot-phy-10",
                        title: "Lesson 10 — Modern Physics",
                        type: "text",
                        duration: "35 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill mb-2">Physics &bull; Modern</span>
                                <h3 class="fw-bold text-title">Lesson 10: Modern Physics</h3>
                            </div>
                            <p>Photoelectric effect, Compton scattering, de Broglie matter waves, atomic transitions, and nuclear radiation laws.</p>
                        `,
                        resources: [
                            { name: "Physics Revision Notes — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Module 4: English & Logical Reasoning",
                lessons: [
                    {
                        id: "reboot-eng-11",
                        title: "Lesson 11 — Grammar & Vocabulary",
                        type: "text",
                        duration: "30 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-info text-white px-3 py-1 rounded-pill mb-2">English &bull; Grammar</span>
                                <h3 class="fw-bold text-title">Lesson 11: Grammar & Vocabulary</h3>
                            </div>
                            <p>Subject-verb agreement, modifiers, conditional structures, punctuation rules, and high-frequency MDCAT vocabulary words.</p>
                        `,
                        resources: [
                            { name: "60-Day Study Plan — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "reboot-lr-12",
                        title: "Lesson 12 — Logical Reasoning MCQs",
                        type: "video",
                        duration: "40 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-info text-white px-3 py-1 rounded-pill mb-2">Reasoning &bull; Problem Solving</span>
                                <h3 class="fw-bold text-title">Lesson 12: Logical Reasoning MCQs</h3>
                            </div>
                            <p>Letter series, syllogisms, cause and effect arguments, logical deductions, and analytical puzzle techniques.</p>
                        `,
                        resources: [
                            { name: "Mock Test Answer Keys — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Module 5: Mock Tests",
                lessons: [
                    {
                        id: "reboot-mock-1",
                        title: "Mock Test 1 — Biology + Chemistry",
                        type: "text",
                        duration: "90 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-danger text-white px-3 py-1 rounded-pill mb-2">Exam Simulator</span>
                                <h3 class="fw-bold text-title">Mock Test 1: Biology + Chemistry</h3>
                            </div>
                            <p>Attempt 120 high-yield questions under timed exam condition (90 minutes). Mark your choices on paper and check with the downloadable key.</p>
                        `,
                        resources: [
                            { name: "Mock Test Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "reboot-mock-2",
                        title: "Mock Test 2 — Full Length Paper",
                        type: "text",
                        duration: "210 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-danger text-white px-3 py-1 rounded-pill mb-2">Full Length Paper</span>
                                <h3 class="fw-bold text-title">Mock Test 2: Full Length Paper</h3>
                            </div>
                            <p>Complete 200 MCQs simulation covering full syllabus strictly following PMDC examination blueprint.</p>
                        `,
                        resources: [
                            { name: "Mock Test Answer Keys — PDF", type: "pdf" }
                        ]
                    }
                ]
            }
        ]
    },

    // =========================================================================
    // 🎓 COURSE 2: PARVAAZ Full-Length Papers (FLPs)
    // =========================================================================
    "mdcat-2026-parvaaz-flps": {
        id: "mdcat-2026-parvaaz-flps",
        title: "PARVAAZ Full-Length Papers (FLPs)",
        description: "Full-Length Mock Paper sessions following exact PMC exam patterns with in-depth video explanations.",
        pinnedMessage: "Discuss any question from the FLPs here. Share your score, ask about tricky MCQs, and help each other improve!",
        defaultResources: [
            { name: "FLP 1 Paper — PDF", type: "pdf" },
            { name: "FLP 2 Paper — PDF", type: "pdf" },
            { name: "FLP 3 Paper — PDF", type: "pdf" },
            { name: "FLP 4 Paper — PDF", type: "pdf" },
            { name: "FLP 5 Paper — PDF", type: "pdf" },
            { name: "All Answer Keys — PDF", type: "pdf" }
        ],
        modules: [
            {
                name: "Full-Length Paper Sessions",
                lessons: [
                    {
                        id: "parvaaz-flp-1",
                        title: "FLP 1 — Biology + Chemistry Focus Paper",
                        type: "text",
                        duration: "210 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Full-Length Paper</span>
                                <h3 class="fw-bold text-title">FLP 1 — Biology + Chemistry Focus</h3>
                            </div>
                            <div class="alert alert-primary bg-light border-primary p-3 rounded-3 mb-4">
                                <p class="mb-0 text-dark"><strong>Instructions:</strong> Attempt this full-length paper under timed conditions — exactly like the real MDCAT. You have 3 hours and 30 minutes. After submission, review your result and watch the detailed video explanation for every wrong answer.</p>
                            </div>
                            <h5>Exam Rules & Marking Scheme:</h5>
                            <ul>
                                <li>Total MCQs: 200 (68 Biology, 54 Chemistry, 54 Physics, 18 English, 6 Logical Reasoning).</li>
                                <li>Time Allowed: 3 Hours 30 Minutes.</li>
                                <li>No negative marking (PMC criteria).</li>
                            </ul>
                        `,
                        resources: [
                            { name: "FLP 1 Paper — PDF", type: "pdf" },
                            { name: "All Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "parvaaz-flp-2",
                        title: "FLP 2 — Physics + English Focus Paper",
                        type: "text",
                        duration: "210 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Full-Length Paper</span>
                                <h3 class="fw-bold text-title">FLP 2 — Physics + English Focus Paper</h3>
                            </div>
                            <p>Full length simulation putting heavy emphasis on numerical problem-solving and English structural comprehension.</p>
                        `,
                        resources: [
                            { name: "FLP 2 Paper — PDF", type: "pdf" },
                            { name: "All Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "parvaaz-flp-3",
                        title: "FLP 3 — Mixed Full Syllabus Paper",
                        type: "text",
                        duration: "210 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Full-Length Paper</span>
                                <h3 class="fw-bold text-title">FLP 3 — Mixed Full Syllabus Paper</h3>
                            </div>
                            <p>Balanced full syllabus MDCAT paper evaluating all 4 core subjects with standardized difficulty curves.</p>
                        `,
                        resources: [
                            { name: "FLP 3 Paper — PDF", type: "pdf" },
                            { name: "All Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "parvaaz-flp-4",
                        title: "FLP 4 — Speed & Accuracy Test",
                        type: "text",
                        duration: "180 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-warning text-dark px-3 py-1 rounded-pill mb-2">Speed Booster</span>
                                <h3 class="fw-bold text-title">FLP 4 — Speed & Accuracy Test</h3>
                            </div>
                            <p>Solve 200 questions in 3 hours flat to train your nervous system for peak speed on test day.</p>
                        `,
                        resources: [
                            { name: "FLP 4 Paper — PDF", type: "pdf" },
                            { name: "All Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "parvaaz-flp-5",
                        title: "FLP 5 — Grand Final Mock Paper",
                        type: "text",
                        duration: "210 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-danger text-white px-3 py-1 rounded-pill mb-2">Grand Mock Paper</span>
                                <h3 class="fw-bold text-title">FLP 5 — Grand Final Mock Paper</h3>
                            </div>
                            <p>Final benchmark mock paper mirroring actual difficulty and distribution of Pakistan medical entrance exam.</p>
                        `,
                        resources: [
                            { name: "FLP 5 Paper — PDF", type: "pdf" },
                            { name: "All Answer Keys — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Answer Keys & Explanations",
                lessons: [
                    {
                        id: "parvaaz-sol-1",
                        title: "FLP 1 Answer Key + Video Explanation",
                        type: "video",
                        duration: "60 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">FLP 1 Video Explanation & Answers</h3>
                            <p>Detailed breakdown of challenging Biology and Chemistry MCQs by DoctorsInn mentors.</p>
                        `,
                        resources: [
                            { name: "All Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "parvaaz-sol-2",
                        title: "FLP 2 Answer Key + Video Explanation",
                        type: "video",
                        duration: "60 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">FLP 2 Video Explanation & Answers</h3>
                            <p>Step-by-step Physics numerical solutions and English grammar justifications.</p>
                        `,
                        resources: [
                            { name: "All Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "parvaaz-sol-3",
                        title: "FLP 3 Answer Key + Video Explanation",
                        type: "video",
                        duration: "60 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">FLP 3 Video Explanation & Answers</h3>
                            <p>Complete review of mixed question paper with shortcut elimination tactics.</p>
                        `,
                        resources: [
                            { name: "All Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "parvaaz-sol-4",
                        title: "FLP 4 Answer Key + Video Explanation",
                        type: "video",
                        duration: "60 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">FLP 4 Video Explanation & Answers</h3>
                            <p>Pacing analysis and time-management tips for tricky questions.</p>
                        `,
                        resources: [
                            { name: "All Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "parvaaz-sol-5",
                        title: "FLP 5 Answer Key + Video Explanation",
                        type: "video",
                        duration: "75 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">FLP 5 Video Explanation & Answers</h3>
                            <p>Comprehensive Grand Mock analysis with final exam-hall mind strategies.</p>
                        `,
                        resources: [
                            { name: "All Answer Keys — PDF", type: "pdf" }
                        ]
                    }
                ]
            }
        ]
    },

    // =========================================================================
    // 🎓 COURSE 3: AL-FATEH Comprehensive Test Session (CTS)
    // =========================================================================
    "mdcat-2026-al-fateh-cts": {
        id: "mdcat-2026-al-fateh-cts",
        title: "AL-FATEH Comprehensive Test Session (CTS)",
        description: "35-Day intensive test session covering the entire MDCAT syllabus through topic-wise and chapter tests.",
        pinnedMessage: "Post your daily test queries here. Our team reviews this discussion board every day and responds promptly!",
        defaultResources: [
            { name: "35-Day Test Schedule — PDF", type: "pdf" },
            { name: "All Test Answer Keys — PDF", type: "pdf" },
            { name: "Biology Revision Notes — PDF", type: "pdf" },
            { name: "Chemistry Short Notes — PDF", type: "pdf" },
            { name: "Physics Formula Sheet — PDF", type: "pdf" }
        ],
        modules: [
            {
                name: "Phase 1 — Biology Tests (Day 1-10)",
                lessons: [
                    {
                        id: "cts-bio-1",
                        title: "Test 1 — Cell Biology & Biochemistry",
                        type: "text",
                        duration: "60 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 1 — Cell Biology & Biochemistry</h3>
                            <p>Diagnostic paper covering cytology, cellular transport, carbohydrates, proteins, and enzymology.</p>
                        `,
                        resources: [
                            { name: "35-Day Test Schedule — PDF", type: "pdf" },
                            { name: "Biology Revision Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "cts-bio-2",
                        title: "Test 2 — Genetics & Evolution",
                        type: "text",
                        duration: "60 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 2 — Genetics & Evolution</h3>
                            <p>Molecular genetics, chromosomal theory of inheritance, gene frequencies, and Darwinian mechanisms.</p>
                        `,
                        resources: [
                            { name: "Biology Revision Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "cts-bio-3",
                        title: "Test 3 — Human Physiology",
                        type: "text",
                        duration: "60 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 3 — Human Physiology</h3>
                            <p>Circulatory hemodynamic parameters, respiratory gas exchange, nephron functions, and endocrinology.</p>
                        `,
                        resources: [
                            { name: "Biology Revision Notes — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Phase 2 — Chemistry Tests (Day 11-18)",
                lessons: [
                    {
                        id: "cts-chem-4",
                        title: "Test 4 — Organic Chemistry",
                        type: "text",
                        duration: "60 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 4 — Organic Chemistry</h3>
                            <p>Alkanes, alkenes, alkynes, aromatic substitution mechanisms, and alkyl halides.</p>
                        `,
                        resources: [
                            { name: "Chemistry Short Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "cts-chem-5",
                        title: "Test 5 — Physical Chemistry",
                        type: "text",
                        duration: "60 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 5 — Physical Chemistry</h3>
                            <p>Gas laws, liquid state properties, solutions, and electrochemical cells.</p>
                        `,
                        resources: [
                            { name: "Chemistry Short Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "cts-chem-6",
                        title: "Test 6 — Inorganic Chemistry",
                        type: "text",
                        duration: "60 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 6 — Inorganic Chemistry</h3>
                            <p>Periodic properties, transition metals, and coordination complex hybridization.</p>
                        `,
                        resources: [
                            { name: "Chemistry Short Notes — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Phase 3 — Physics Tests (Day 19-25)",
                lessons: [
                    {
                        id: "cts-phy-7",
                        title: "Test 7 — Mechanics & Waves",
                        type: "text",
                        duration: "60 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 7 — Mechanics & Waves</h3>
                            <p>Vectors, momentum, rotational kinematics, simple harmonic motion, and sound waves.</p>
                        `,
                        resources: [
                            { name: "Physics Formula Sheet — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "cts-phy-8",
                        title: "Test 8 — Electricity & Magnetism",
                        type: "text",
                        duration: "60 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 8 — Electricity & Magnetism</h3>
                            <p>Electrostatics, current, circuits, magnetic force, and electromagnetic induction.</p>
                        `,
                        resources: [
                            { name: "Physics Formula Sheet — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "cts-phy-9",
                        title: "Test 9 — Modern Physics",
                        type: "text",
                        duration: "60 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 9 — Modern Physics</h3>
                            <p>Quantum hypothesis, Bohr model, photons, and nuclear decay kinetics.</p>
                        `,
                        resources: [
                            { name: "Physics Formula Sheet — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Phase 4 — English + LR (Day 26-28)",
                lessons: [
                    {
                        id: "cts-eng-10",
                        title: "Test 10 — English Grammar & Vocab",
                        type: "text",
                        duration: "45 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 10 — English Grammar & Vocab</h3>
                            <p>Grammar precision, error identification, prepositions, and contextual vocabulary.</p>
                        `,
                        resources: [
                            { name: "All Test Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "cts-lr-11",
                        title: "Test 11 — Logical Reasoning",
                        type: "text",
                        duration: "45 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Test 11 — Logical Reasoning</h3>
                            <p>Critical reasoning, syllogisms, and deduction sequences.</p>
                        `,
                        resources: [
                            { name: "All Test Answer Keys — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Phase 5 — Final Mocks (Day 29-35)",
                lessons: [
                    {
                        id: "cts-mock-1",
                        title: "Full Mock 1",
                        type: "text",
                        duration: "210 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Full Mock 1 (Day 29-30)</h3>
                            <p>First complete 200 MCQ simulated paper with automated answer sheet.</p>
                        `,
                        resources: [
                            { name: "All Test Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "cts-mock-2",
                        title: "Full Mock 2",
                        type: "text",
                        duration: "210 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Full Mock 2 (Day 31-32)</h3>
                            <p>Second comprehensive mock test verifying syllabus retention.</p>
                        `,
                        resources: [
                            { name: "All Test Answer Keys — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "cts-mock-3",
                        title: "Grand Final Paper",
                        type: "text",
                        duration: "210 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Grand Final Paper (Day 33-35)</h3>
                            <p>The culminating test paper before your official medical entrance examination.</p>
                        `,
                        resources: [
                            { name: "All Test Answer Keys — PDF", type: "pdf" }
                        ]
                    }
                ]
            }
        ]
    },

    // =========================================================================
    // 🎓 COURSE 4: AMC Prep Course 2026 – Ansaar Batch
    // =========================================================================
    "amc-prep-course-2026-ansaar": {
        id: "amc-prep-course-2026-ansaar",
        title: "AMC Prep Course 2026 – Ansaar Batch",
        description: "Specialized Armed Forces Medical College entry test training with intelligence and interview modules.",
        pinnedMessage: "AMC aspirants — post your questions, share tips, and support each other. Our mentor checks this board daily!",
        defaultResources: [
            { name: "AMC Syllabus Guide — PDF", type: "pdf" },
            { name: "Past Papers (Last 3 Years) — PDF", type: "pdf" },
            { name: "Biology Notes — PDF", type: "pdf" },
            { name: "Chemistry Notes — PDF", type: "pdf" },
            { name: "Physics Notes — PDF", type: "pdf" },
            { name: "Interview Preparation Guide — PDF", type: "pdf" }
        ],
        modules: [
            {
                name: "Biology Lessons",
                lessons: [
                    {
                        id: "amc-bio-1",
                        title: "Lesson 1 — Genetics & Molecular Biology",
                        type: "video",
                        duration: "45 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 1: Genetics & Molecular Biology</h3>
                            <p>DNA replication, transcription, translation, and AMC high-yield past questions.</p>
                        `,
                        resources: [
                            { name: "AMC Syllabus Guide — PDF", type: "pdf" },
                            { name: "Biology Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "amc-bio-2",
                        title: "Lesson 2 — Human Physiology & Anatomy",
                        type: "video",
                        duration: "50 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 2: Human Physiology & Anatomy</h3>
                            <p>Major organ systems, cardiovascular circulation, and nervous coordination.</p>
                        `,
                        resources: [
                            { name: "Biology Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "amc-bio-3",
                        title: "Lesson 3 — Ecology & Evolution",
                        type: "text",
                        duration: "30 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 3: Ecology & Evolution</h3>
                            <p>Ecosystem dynamics, biotic and abiotic factors, and evolutionary adaptation principles.</p>
                        `,
                        resources: [
                            { name: "Biology Notes — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Chemistry Lessons",
                lessons: [
                    {
                        id: "amc-chem-4",
                        title: "Lesson 4 — Organic Chemistry",
                        type: "video",
                        duration: "45 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 4: Organic Chemistry</h3>
                            <p>Reaction mechanisms of functional groups, alcohols, carbonyls, and polymers.</p>
                        `,
                        resources: [
                            { name: "Chemistry Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "amc-chem-5",
                        title: "Lesson 5 — Physical Chemistry",
                        type: "text",
                        duration: "40 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 5: Physical Chemistry</h3>
                            <p>Chemical thermodynamics, enthalpy changes, and ionic equilibria.</p>
                        `,
                        resources: [
                            { name: "Chemistry Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "amc-chem-6",
                        title: "Lesson 6 — Analytical Chemistry",
                        type: "text",
                        duration: "35 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 6: Analytical Chemistry</h3>
                            <p>Quantitative titrations, buffer solutions, and Henderson-Hasselbalch applications.</p>
                        `,
                        resources: [
                            { name: "Chemistry Notes — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Physics Lessons",
                lessons: [
                    {
                        id: "amc-phy-7",
                        title: "Lesson 7 — Mechanics & Thermodynamics",
                        type: "video",
                        duration: "50 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 7: Mechanics & Thermodynamics</h3>
                            <p>Laws of thermodynamics, Carnot engine efficiency, and gas kinetic theory.</p>
                        `,
                        resources: [
                            { name: "Physics Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "amc-phy-8",
                        title: "Lesson 8 — Waves, Light & Sound",
                        type: "video",
                        duration: "45 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 8: Waves, Light & Sound</h3>
                            <p>Wave optics, diffraction, polarization, and acoustic resonance.</p>
                        `,
                        resources: [
                            { name: "Physics Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "amc-phy-9",
                        title: "Lesson 9 — Modern Physics",
                        type: "text",
                        duration: "35 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 9: Modern Physics</h3>
                            <p>Nuclear mass defect, binding energy curve, and radioactive isotopes.</p>
                        `,
                        resources: [
                            { name: "Physics Notes — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "English & Intelligence",
                lessons: [
                    {
                        id: "amc-intel-10",
                        title: "Lesson 10 — English + Intelligence Test Prep",
                        type: "video",
                        duration: "55 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 10: English + Intelligence Test Prep</h3>
                            <p>Verbal and non-verbal reasoning, series completion, matrices, and spatial orientation for military medical selection.</p>
                        `,
                        resources: [
                            { name: "Interview Preparation Guide — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Past Papers & Mocks",
                lessons: [
                    {
                        id: "amc-past-11",
                        title: "Lesson 11 — AMC Past Papers Analysis",
                        type: "text",
                        duration: "60 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 11: AMC Past Papers Analysis</h3>
                            <p>Analysis of past 3 years AMC entry test papers with recurring MCQ themes.</p>
                        `,
                        resources: [
                            { name: "Past Papers (Last 3 Years) — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "amc-mock-12",
                        title: "Lesson 12 — Final Mock + Interview Tips",
                        type: "video",
                        duration: "50 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                        readContent: `
                            <h3 class="fw-bold text-title">Lesson 12: Final Mock + Interview Tips</h3>
                            <p>Full length mock exam followed by Army Selection & Recruitment Centre (AS&RC) interview advice.</p>
                        `,
                        resources: [
                            { name: "Interview Preparation Guide — PDF", type: "pdf" }
                        ]
                    }
                ]
            }
        ]
    },

    // =========================================================================
    // 🎓 COURSE 5: KTS Mock Test X DoctorsInnElite (FREE)
    // =========================================================================
    "kts-mock-test-doctorsinnelite": {
        id: "kts-mock-test-doctorsinnelite",
        title: "KTS Mock Test X DoctorsInnElite (FREE)",
        description: "FREE full-length MDCAT mock test in collaboration with Khairpur Medical College.",
        pinnedMessage: "How did your KTS Mock Test go? Share your score and discuss tricky questions with other students here!",
        defaultResources: [
            { name: "Mock Test Answer Key — PDF", type: "pdf" },
            { name: "Subject-wise Performance Report — PDF", type: "pdf" },
            { name: "MDCAT Preparation Tips — PDF", type: "pdf" }
        ],
        modules: [
            {
                name: "KTS Mock Test 2026",
                lessons: [
                    {
                        id: "kts-sec-1",
                        title: "Section 1 — Biology (68 MCQs)",
                        type: "text",
                        duration: "70 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-success text-white px-3 py-1 rounded-pill mb-2">FREE Full-Length Mock</span>
                                <h3 class="fw-bold text-title">KTS Mock Test — Instructions</h3>
                            </div>
                            <div class="alert alert-success bg-light border-success p-3 rounded-3 mb-4">
                                <p class="mb-0 text-dark"><strong>Instructions:</strong> Welcome to KTS Mock Test 2026! This is a FREE full-length MDCAT mock test in collaboration with Khairpur Medical College. Total time: 3 hours 30 minutes. Total MCQs: 200. Attempt all sections without any break for real exam experience. Good luck! 🎯</p>
                            </div>
                            <h5>Section 1: Biology (68 MCQs)</h5>
                            <p>Attempt 68 MCQs covering cytology, bioenergetics, genetics, coordination, and physiology. Record your selected answers on paper.</p>
                        `,
                        resources: [
                            { name: "Mock Test Answer Key — PDF", type: "pdf" },
                            { name: "MDCAT Preparation Tips — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "kts-sec-2",
                        title: "Section 2 — Chemistry (54 MCQs)",
                        type: "text",
                        duration: "55 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Section 2 — Chemistry (54 MCQs)</h3>
                            <p>54 MCQs covering physical, inorganic, and organic chemistry according to PMDC weightage.</p>
                        `,
                        resources: [
                            { name: "Mock Test Answer Key — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "kts-sec-3",
                        title: "Section 3 — Physics (54 MCQs)",
                        type: "text",
                        duration: "55 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Section 3 — Physics (54 MCQs)</h3>
                            <p>54 questions testing formulas, numerical computations, and conceptual physics derivations.</p>
                        `,
                        resources: [
                            { name: "Mock Test Answer Key — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "kts-sec-4",
                        title: "Section 4 — English (18 MCQs)",
                        type: "text",
                        duration: "20 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Section 4 — English (18 MCQs)</h3>
                            <p>18 questions covering error detection, vocabulary in context, and sentence structure.</p>
                        `,
                        resources: [
                            { name: "Mock Test Answer Key — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "kts-sec-5",
                        title: "Section 5 — Logical Reasoning (6 MCQs)",
                        type: "text",
                        duration: "10 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Section 5 — Logical Reasoning (6 MCQs)</h3>
                            <p>6 critical thinking questions to complete your mock examination.</p>
                        `,
                        resources: [
                            { name: "Mock Test Answer Key — PDF", type: "pdf" }
                        ]
                    }
                ]
            },
            {
                name: "Result & Analysis",
                lessons: [
                    {
                        id: "kts-res-1",
                        title: "Your Score Card",
                        type: "text",
                        duration: "15 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Your Score Card</h3>
                            <div class="p-4 rounded-3 bg-light border text-center mb-3">
                                <div class="display-6 fw-bold text-success mb-2">184 / 200</div>
                                <p class="text-muted mb-0">National Percentile: <strong>98.4%</strong> | Merit Rank: <strong>Top 20</strong></p>
                            </div>
                            <p>Excellent performance! Review subject-wise weak areas in the following reports.</p>
                        `,
                        resources: [
                            { name: "Subject-wise Performance Report — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "kts-res-2",
                        title: "Answer Key with Explanations",
                        type: "text",
                        duration: "30 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Answer Key with Explanations</h3>
                            <p>Detailed step-by-step solutions verified by Khairpur Medical College faculty.</p>
                        `,
                        resources: [
                            { name: "Mock Test Answer Key — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "kts-res-3",
                        title: "Subject-wise Performance Report",
                        type: "text",
                        duration: "20 min",
                        readContent: `
                            <h3 class="fw-bold text-title">Subject-wise Performance Report</h3>
                            <p>Biology accuracy: 92% &bull; Chemistry accuracy: 89% &bull; Physics accuracy: 85% &bull; English accuracy: 94%.</p>
                        `,
                        resources: [
                            { name: "Subject-wise Performance Report — PDF", type: "pdf" },
                            { name: "MDCAT Preparation Tips — PDF", type: "pdf" }
                        ]
                    }
                ]
            }
        ]
    }
};
