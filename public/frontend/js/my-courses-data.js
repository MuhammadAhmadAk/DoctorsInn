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
        chapters: [
            {
                id: "chapter-1",
                chapterNumber: 1,
                name: "Chapter 1: Cell Biology & Cytology",
                description: "Plasma membrane dynamics, organelle functions, endomembrane trafficking & cellular division.",
                topics: [
                    {
                        id: "topic-1-1",
                        topicNumber: "1.1",
                        title: "1.1 Cell Membrane & Fluid Mosaic Architecture",
                        type: "video",
                        duration: "35 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Chapter 1 &bull; Topic 1.1</span>
                                <h3 class="fw-bold text-dark">1.1 Cell Membrane & Fluid Mosaic Dynamics</h3>
                            </div>
                            <div class="alert alert-primary bg-light border-primary p-3 rounded-3 mb-4">
                                <p class="mb-0 text-dark"><strong>Summary:</strong> Covers Singer & Nicolson's Fluid Mosaic Model, lipid bilayer composition, integral vs peripheral proteins, cholesterol fluidity buffer, and transport mechanisms.</p>
                            </div>
                            <h4>1. Molecular Architecture of Biological Membranes</h4>
                            <p>According to the Fluid Mosaic Model (Singer & Nicolson, 1972), the plasma membrane behaves as a quasi-fluid two-dimensional liquid wherein amphipathic phospholipids and proteins are in continuous lateral motion.</p>
                            <ul>
                                <li><strong>Phospholipid Bilayer:</strong> Hydrophilic polar heads face aqueous environments (ECF & ICF); hydrophobic non-polar fatty acid tails sequester inward.</li>
                                <li><strong>Cholesterol (Animal Cells):</strong> Acts as a biophysical fluidity buffer. It prevents crystallized packing at cold temperatures and stabilizes excess fluidity at elevated temperatures.</li>
                                <li><strong>Glycocalyx:</strong> Surface oligosaccharide chains linked to lipids (glycolipids) or proteins (glycoproteins) enabling cell-cell recognition and immune identity.</li>
                            </ul>
                            <h4 class="mt-4">2. Transmembrane Transport Mechanisms</h4>
                            <p>MDCAT frequently tests differences between passive diffusion, facilitated diffusion via GLUT carriers/aquaporins, and primary/secondary active transport.</p>
                        `,
                        resources: [
                            { name: "Cell Biology Chapter Notes — PDF", type: "pdf" },
                            { name: "Fluid Mosaic Diagram & Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "topic-1-quiz",
                        topicNumber: "1.1 Checkpoint",
                        title: "Topic 1.1 Quick Quiz: Membrane Transport & Channels",
                        type: "quiz",
                        isQuiz: true,
                        quizType: "topic",
                        duration: "5 min",
                        quizData: {
                            title: "Topic 1.1 Checkpoint: Cell Membrane & Transport Quiz",
                            subtitle: "5 Rapid-Fire PMDC MCQs covering active transport, passive diffusion & tonicity",
                            passingScore: 80,
                            timeLimitMinutes: 5,
                            questions: [
                                {
                                    question: "Which component of the plasma membrane acts as a fluidity buffer across temperature fluctuations in animal cells?",
                                    options: [
                                        "Peripheral glycoproteins",
                                        "Cholesterol molecules",
                                        "Sphingomyelin lipids",
                                        "Oligosaccharide chains"
                                    ],
                                    correctIndex: 1,
                                    explanation: "Cholesterol prevents phospholipid fatty acid chains from packing closely at low temperatures and restricts excessive membrane fluidity at high temperatures, functioning as a biophysical fluidity buffer."
                                },
                                {
                                    question: "In the Sodium-Potassium ATPase pump, what is the stoichiometric exchange ratio per ATP hydrolyzed?",
                                    options: [
                                        "3 Na+ out, 2 K+ in",
                                        "2 Na+ out, 3 K+ in",
                                        "3 Na+ in, 2 K+ out",
                                        "1 Na+ out, 1 K+ in"
                                    ],
                                    correctIndex: 0,
                                    explanation: "The primary active Na+/K+ ATPase pumps 3 Sodium ions OUT of the cell and 2 Potassium ions INTO the cell per ATP molecule cleaved, maintaining negative resting membrane potential."
                                },
                                {
                                    question: "Which of the following transport mechanisms moves substances against their electrochemical gradient without direct ATP hydrolysis?",
                                    options: [
                                        "Facilitated diffusion",
                                        "Simple osmosis",
                                        "Secondary active transport (Symport/Antiport)",
                                        "Primary active transport"
                                    ],
                                    correctIndex: 2,
                                    explanation: "Secondary active transport couples the downhill movement of an ion (such as Na+) down its gradient to drive the uphill transport of another solute against its concentration gradient."
                                },
                                {
                                    question: "A red blood cell placed in a 0.2% NaCl solution will undergo:",
                                    options: [
                                        "Crenation (Shrinkage)",
                                        "Plasmolysis",
                                        "Hemolysis (Osmotic Lysis)",
                                        "No osmotic volume change"
                                    ],
                                    correctIndex: 2,
                                    explanation: "Normal physiological saline is 0.9% NaCl (isotonic). A 0.2% NaCl solution is hypotonic, causing water to rush into the erythrocyte via osmosis, leading to swelling and membrane bursting (hemolysis)."
                                },
                                {
                                    question: "The 'glycocalyx' found on the external surface of the plasma membrane is primarily composed of:",
                                    options: [
                                        "Cholesterol and saturated phospholipids",
                                        "Glycoproteins and glycolipids",
                                        "Integral transmembrane alpha-helices",
                                        "Spectrin and ankyrin cytoskeletal anchors"
                                    ],
                                    correctIndex: 1,
                                    explanation: "The glycocalyx consists of carbohydrates covalently linked to membrane proteins (glycoproteins) and lipids (glycolipids), providing cell-cell recognition and immunological markers."
                                }
                            ]
                        }
                    },
                    {
                        id: "topic-1-2",
                        topicNumber: "1.2",
                        title: "1.2 Endomembrane System, Mitochondria & Cytoskeleton",
                        type: "video",
                        duration: "42 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Chapter 1 &bull; Topic 1.2</span>
                                <h3 class="fw-bold text-dark">1.2 Endomembrane System & Mitochondria</h3>
                            </div>
                            <h4>1. Eukaryotic Organelles Overview</h4>
                            <p>Detailed analysis of mitochondria (double membrane, cristae, circular DNA, 70S ribosomes), endoplasmic reticulum (RER protein synthesis vs SER lipid synthesis & drug detox), and lysosomes (acid hydrolases with pH 4.5-5.0).</p>
                        `,
                        resources: [
                            { name: "Organelle Pathology & MDCAT Notes — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "topic-1-3",
                        topicNumber: "1.3",
                        title: "1.3 Mitosis, Meiosis & Karyotyping High-Yield Notes",
                        type: "reading",
                        duration: "25 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Chapter 1 &bull; Topic 1.3</span>
                                <h3 class="fw-bold text-dark">1.3 Mitosis, Meiosis & Karyotyping High-Yield Notes</h3>
                            </div>
                            <h4>1. Cell Division Comparison Table</h4>
                            <div class="table-responsive my-3">
                                <table class="table table-bordered text-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Feature</th>
                                            <th>Mitosis</th>
                                            <th>Meiosis</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Site</strong></td>
                                            <td>Somatic cells</td>
                                            <td>Germ cells (Gametogenesis)</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Recombination</strong></td>
                                            <td>None</td>
                                            <td>Pachytene stage (Prophase I)</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Outcome</strong></td>
                                            <td>2 identical diploid (2n) cells</td>
                                            <td>4 genetically distinct haploid (1n) cells</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        `,
                        resources: [
                            { name: "Cell Division Comparative Chart — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "chapter-1-quiz",
                        topicNumber: "Assessment",
                        title: "Chapter 1 Comprehensive Mastery Assessment",
                        type: "quiz",
                        isQuiz: true,
                        quizType: "chapter",
                        duration: "10 min",
                        quizData: {
                            title: "Chapter 1: Cell Biology & Cytology Comprehensive Exam",
                            subtitle: "PMDC standard chapter-ending evaluation covering organelles, division, and membrane dynamics.",
                            passingScore: 80,
                            timeLimitMinutes: 10,
                            questions: [
                                {
                                    question: "Crossing over between non-sister chromatids of homologous chromosomes occurs during which specific stage of Prophase I?",
                                    options: [
                                        "Leptotene",
                                        "Zygotene",
                                        "Pachytene",
                                        "Diplotene"
                                    ],
                                    correctIndex: 2,
                                    explanation: "Synapsis occurs during Zygotene, but genetic exchange (crossing over) takes place during Pachytene via recombination nodules, producing chiasmata visible in Diplotene."
                                },
                                {
                                    question: "Which organelle is directly responsible for the synthesis of steroid hormones in Leydig and adrenal cortex cells?",
                                    options: [
                                        "Rough Endoplasmic Reticulum",
                                        "Smooth Endoplasmic Reticulum",
                                        "Peroxisomes",
                                        "Lysosomes"
                                    ],
                                    correctIndex: 1,
                                    explanation: "The Smooth Endoplasmic Reticulum (SER) is enriched with enzymes for lipid and steroid biosynthesis, as well as glycogen breakdown and detoxification in hepatocytes."
                                },
                                {
                                    question: "In eukaryotic ribosomes, the peptidyl transferase ribozyme activity that forms peptide bonds is located in:",
                                    options: [
                                        "18S rRNA of 40S subunit",
                                        "28S rRNA of 60S subunit",
                                        "5S rRNA of 60S subunit",
                                        "Initiation Factor IF-2"
                                    ],
                                    correctIndex: 1,
                                    explanation: "The catalytic peptidyl transferase activity of eukaryotic 80S ribosomes resides within the 28S ribosomal RNA of the large (60S) subunit."
                                },
                                {
                                    question: "Tay-Sachs disease results from the genetic deficiency of Hexosaminidase A within which organelle?",
                                    options: [
                                        "Mitochondria",
                                        "Peroxisomes",
                                        "Lysosomes",
                                        "Golgi Apparatus"
                                    ],
                                    correctIndex: 2,
                                    explanation: "Tay-Sachs is an autosomal recessive lysosomal storage disease resulting in abnormal accumulation of GM2 gangliosides in neuronal lysosomes."
                                },
                                {
                                    question: "Colchicine arrests cells in which mitotic phase by inhibiting microtubule polymerization?",
                                    options: [
                                        "Prophase",
                                        "Metaphase",
                                        "Anaphase",
                                        "Telophase"
                                    ],
                                    correctIndex: 1,
                                    explanation: "Colchicine disrupts mitotic spindle microtubule assembly, arresting chromosomes on the metaphase plate (used clinically for karyotyping)."
                                }
                            ]
                        }
                    }
                ]
            },
            {
                id: "chapter-2",
                chapterNumber: 2,
                name: "Chapter 2: Biological Molecules & Enzymology",
                description: "Carbohydrates, lipids, structural proteins, nucleic acids, and enzyme kinetics.",
                topics: [
                    {
                        id: "topic-2-1",
                        topicNumber: "2.1",
                        title: "2.1 Carbohydrate Chemistry, Isomerism & Glycosidic Bonds",
                        type: "video",
                        duration: "38 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Chapter 2 &bull; Topic 2.1</span>
                                <h3 class="fw-bold text-dark">2.1 Carbohydrate Chemistry & Glycosidic Linkages</h3>
                            </div>
                            <p>Detailed study of aldoses, ketoses, hemiacetals, anomeric carbons, and classification into monosaccharides, disaccharides, and polysaccharides.</p>
                        `,
                        resources: [
                            { name: "Carbohydrates Structures & Tests — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "topic-2-quiz",
                        topicNumber: "2.1 Checkpoint",
                        title: "Topic 2.1 Quick Quiz: Carbohydrate Structure & Tests",
                        type: "quiz",
                        isQuiz: true,
                        quizType: "topic",
                        duration: "5 min",
                        quizData: {
                            title: "Carbohydrate Classification & Biochemical Tests",
                            subtitle: "5 Rapid-Fire PMDC MCQs covering mono-, di- and polysaccharides",
                            passingScore: 80,
                            timeLimitMinutes: 5,
                            questions: [
                                {
                                    question: "Which of the following carbohydrates is a non-reducing disaccharide with an alpha-1,2-glycosidic linkage?",
                                    options: [
                                        "Maltose",
                                        "Lactose",
                                        "Sucrose",
                                        "Cellobiose"
                                    ],
                                    correctIndex: 2,
                                    explanation: "In sucrose, both anomeric carbons of glucose and fructose participate in the glycosidic bond (alpha-1,2), leaving no free hemiacetal group; thus it does not reduce Benedict's reagent."
                                },
                                {
                                    question: "Which branched polymer of glucose serves as the primary animal storage carbohydrate?",
                                    options: [
                                        "Amylose",
                                        "Glycogen",
                                        "Cellulose",
                                        "Chitin"
                                    ],
                                    correctIndex: 1,
                                    explanation: "Glycogen has alpha-1,4 glycosidic bonds in chains with frequent alpha-1,6 branch points occurring every 8-12 glucose residues, stored in liver and skeletal muscles."
                                },
                                {
                                    question: "A patient's urine turns brick-red when heated with Benedict's solution. Which sugar is NOT responsible?",
                                    options: [
                                        "Glucose",
                                        "Galactose",
                                        "Fructose",
                                        "Sucrose"
                                    ],
                                    correctIndex: 3,
                                    explanation: "Sucrose is non-reducing and gives a negative Benedict's test unless previously hydrolyzed by acid or sucrase."
                                },
                                {
                                    question: "Chitin, found in fungal cell walls and arthropod exoskeletons, is a polymer of:",
                                    options: [
                                        "N-acetylglucosamine (NAG)",
                                        "N-acetylmuramic acid (NAM)",
                                        "Alpha-D-glucuronic acid",
                                        "Beta-D-galactose"
                                    ],
                                    correctIndex: 0,
                                    explanation: "Chitin is a homopolymer of N-acetyl-D-glucosamine units joined by beta-1,4-glycosidic linkages."
                                },
                                {
                                    question: "Amylose and amylopectin are the two structural constituents of:",
                                    options: [
                                        "Glycogen",
                                        "Starch",
                                        "Inulin",
                                        "Dextran"
                                    ],
                                    correctIndex: 1,
                                    explanation: "Plant starch consists of unbranched helical amylose (alpha-1,4) and branched amylopectin (alpha-1,4 with alpha-1,6 branches)."
                                }
                            ]
                        }
                    },
                    {
                        id: "topic-2-2",
                        topicNumber: "2.2",
                        title: "2.2 Protein Hierarchy, Peptide Bonds & Hemoglobin vs Myoglobin",
                        type: "video",
                        duration: "40 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Chapter 2 &bull; Topic 2.2</span>
                                <h3 class="fw-bold text-dark">2.2 Protein Structural Hierarchy & Allostery</h3>
                            </div>
                            <p>Primary, secondary (alpha-helix, beta-sheet), tertiary, and quaternary levels of protein structure, with clinical comparisons of myoglobin (hyperbolic curve) and hemoglobin (sigmoidal cooperative curve).</p>
                        `,
                        resources: [
                            { name: "Proteins & Amino Acid Classifications — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "topic-2-3",
                        topicNumber: "2.3",
                        title: "2.3 Enzyme Kinetics, Michaelis-Menten & Inhibition Models",
                        type: "reading",
                        duration: "30 min",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Chapter 2 &bull; Topic 2.3</span>
                                <h3 class="fw-bold text-dark">2.3 Enzyme Kinetics, Michaelis-Menten & Inhibition Models</h3>
                            </div>
                            <p>Km (substrate concentration at 1/2 Vmax), competitive vs non-competitive vs uncompetitive inhibitors, and regulatory allosteric effectors.</p>
                        `,
                        resources: [
                            { name: "Enzyme Kinetics Formula & Graphs — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "chapter-2-quiz",
                        topicNumber: "Assessment",
                        title: "Chapter 2 Comprehensive Mastery Assessment",
                        type: "quiz",
                        isQuiz: true,
                        quizType: "chapter",
                        duration: "10 min",
                        quizData: {
                            title: "Chapter 2: Biochemistry & Enzymology Comprehensive Exam",
                            subtitle: "PMDC standard assessment on amino acids, proteins, lipids, and catalytic kinetics.",
                            passingScore: 80,
                            timeLimitMinutes: 10,
                            questions: [
                                {
                                    question: "A competitive enzyme inhibitor produces which of the following kinetic alterations on Km and Vmax?",
                                    options: [
                                        "Increases Km, Vmax unchanged",
                                        "Decreases Km, Vmax decreases",
                                        "Km unchanged, Vmax decreases",
                                        "Increases both Km and Vmax"
                                    ],
                                    correctIndex: 0,
                                    explanation: "Competitive inhibitors compete with substrate for active sites, requiring higher substrate concentrations to reach half-maximal velocity (increased Km), but high [S] can still achieve maximal rate (unchanged Vmax)."
                                },
                                {
                                    question: "Which amino acid possesses an indole ring and serves as precursor to serotonin and melatonin?",
                                    options: [
                                        "Phenylalanine",
                                        "Tyrosine",
                                        "Tryptophan",
                                        "Histidine"
                                    ],
                                    correctIndex: 2,
                                    explanation: "Tryptophan contains an indole ring and is the biochemical precursor for neurotransmitter serotonin (5-HT) and hormone melatonin."
                                },
                                {
                                    question: "Which of the following bonds stabilizes the alpha-helix secondary structure of proteins?",
                                    options: [
                                        "Disulfide bridges between cysteine residues",
                                        "Hydrogen bonds between C=O and N-H of peptide backbones",
                                        "Hydrophobic interactions of R-groups",
                                        "Ionic bonds between acidic and basic side chains"
                                    ],
                                    correctIndex: 1,
                                    explanation: "Alpha-helices and beta-sheets are stabilized strictly by intrachain hydrogen bonds between the carbonyl oxygen (C=O) and amide hydrogen (N-H) of the peptide backbone 4 residues apart."
                                },
                                {
                                    question: "Prosthetic groups differ from coenzymes in that prosthetic groups are:",
                                    options: [
                                        "Transiently associated non-protein cofactors",
                                        "Permanently and tightly/covalently bound to the apoenzyme",
                                        "Inorganic metal ions only (e.g., Fe2+, Mg2+)",
                                        "Always synthesized de novo during every reaction cycle"
                                    ],
                                    correctIndex: 1,
                                    explanation: "A prosthetic group (like heme in catalase or hemoglobin) remains tightly or covalently bound to the enzyme throughout the catalytic cycle."
                                },
                                {
                                    question: "The quaternary structure of adult Hemoglobin (HbA) consists of:",
                                    options: [
                                        "Two alpha and two gamma globin chains",
                                        "Two alpha and two beta globin chains",
                                        "Single polypeptide with one heme pocket",
                                        "Four identical beta globin chains"
                                    ],
                                    correctIndex: 1,
                                    explanation: "Normal adult human hemoglobin (HbA) is a tetramer of two alpha (alpha) and two beta (beta) subunits, each containing a protoporphyrin IX heme ring."
                                }
                            ]
                        }
                    }
                ]
            },
            {
                id: "chapter-3",
                chapterNumber: 3,
                name: "Chapter 3: Genetics, DNA Replication & Transcription",
                description: "Mendelian genetics, chromosome mapping, Central Dogma, and gene regulation.",
                topics: [
                    {
                        id: "topic-3-1",
                        topicNumber: "3.1",
                        title: "3.1 Mendelian Inheritance & Non-Mendelian Extensions",
                        type: "video",
                        duration: "44 min",
                        videoUrl: "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/WeAreGoingOnBullrun.mp4",
                        readContent: `
                            <div class="lesson-header-box mb-4">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill mb-2">Chapter 3 &bull; Topic 3.1</span>
                                <h3 class="fw-bold text-dark">3.1 Mendelian Genetics & Inheritance Patterns</h3>
                            </div>
                            <p>Law of Segregation, Law of Independent Assortment, codominance, incomplete dominance, multiple alleles (ABO blood groups), and epistasis.</p>
                        `,
                        resources: [
                            { name: "Genetics Punnett Squares & Pedigree Analysis — PDF", type: "pdf" }
                        ]
                    },
                    {
                        id: "topic-3-quiz",
                        topicNumber: "3.1 Checkpoint",
                        title: "Topic 3.1 Quick Quiz: Mendelian Ratios & Pedigrees",
                        type: "quiz",
                        isQuiz: true,
                        quizType: "topic",
                        duration: "5 min",
                        quizData: {
                            title: "Genetics & Inheritance Patterns Quiz",
                            subtitle: "5 Rapid-Fire PMDC MCQs covering monohybrid, dihybrid, and sex-linked traits",
                            passingScore: 80,
                            timeLimitMinutes: 5,
                            questions: [
                                {
                                    question: "In a cross between two individuals heterozygous for two unlinked traits (AaBb x AaBb), what fraction of offspring is expected to express both recessive phenotypes (aabb)?",
                                    options: [
                                        "1/16",
                                        "3/16",
                                        "9/16",
                                        "1/4"
                                    ],
                                    correctIndex: 0,
                                    explanation: "Standard Mendelian dihybrid phenotypic ratio is 9:3:3:1. The double recessive phenotype (aabb) represents 1 out of 16 offspring."
                                },
                                {
                                    question: "Hemophilia A is an X-linked recessive disorder. If a carrier female marries an unaffected male, what percentage of their male children will have hemophilia?",
                                    options: [
                                        "0%",
                                        "25%",
                                        "50%",
                                        "100%"
                                    ],
                                    correctIndex: 2,
                                    explanation: "The mother is X^H X^h and father is X^H Y. Male children inherit Y from father and either X^H (unaffected, 50%) or X^h (affected, 50%) from mother."
                                },
                                {
                                    question: "The phenomenon where a single gene influences multiple unrelated phenotypic traits is called:",
                                    options: [
                                        "Polygenic inheritance",
                                        "Epistasis",
                                        "Pleiotropy",
                                        "Incomplete dominance"
                                    ],
                                    correctIndex: 2,
                                    explanation: "Pleiotropy describes a single gene mutation producing multiple phenotypic effects across distinct organ systems (e.g., Sickle Cell Anemia, Marfan syndrome)."
                                },
                                {
                                    question: "During DNA replication in E. coli, which enzyme unwinds the double helix at the replication fork?",
                                    options: [
                                        "DNA Topoisomerase (Gyrase)",
                                        "DNA Helicase (DnaB)",
                                        "DNA Polymerase III",
                                        "DNA Ligase"
                                    ],
                                    correctIndex: 1,
                                    explanation: "DNA Helicase unwinds the double helix at the fork by breaking hydrogen bonds, while Topoisomerase (gyrase) relieves supercoiling tension ahead of the fork."
                                },
                                {
                                    question: "Okazaki fragments are synthesized along the:",
                                    options: [
                                        "Leading strand continuously in 5' to 3' direction",
                                        "Lagging strand discontinuously in 5' to 3' direction",
                                        "Lagging strand continuously in 3' to 5' direction",
                                        "Both strands simultaneously by RNA polymerase"
                                    ],
                                    correctIndex: 1,
                                    explanation: "Because DNA polymerases only synthesize in the 5' to 3' direction, the lagging strand is synthesized discontinuously as short Okazaki fragments, later joined by DNA ligase."
                                }
                            ]
                        }
                    },
                    {
                        id: "chapter-3-quiz",
                        topicNumber: "Assessment",
                        title: "Chapter 3 Comprehensive Mastery Assessment",
                        type: "quiz",
                        isQuiz: true,
                        quizType: "chapter",
                        duration: "10 min",
                        quizData: {
                            title: "Chapter 3: Genetics & Molecular Biology Comprehensive Exam",
                            subtitle: "PMDC standard assessment on DNA replication, transcription, translation, and genetic disorders.",
                            passingScore: 80,
                            timeLimitMinutes: 10,
                            questions: [
                                {
                                    question: "The genetic codon AUG encodes which amino acid and functions as what in eukaryotic translation?",
                                    options: [
                                        "Formylmethionine, Stop codon",
                                        "Methionine, Start codon",
                                        "Valine, Start codon",
                                        "Tryptophan, Stop codon"
                                    ],
                                    correctIndex: 1,
                                    explanation: "AUG codes for Methionine (Met) in eukaryotes and serves as the universal initiator (start) codon for protein translation."
                                },
                                {
                                    question: "Which of the following codons does NOT code for any amino acid and acts as a translation termination signal?",
                                    options: [
                                        "UAA, UAG, UGA",
                                        "AUG, GUG, UUG",
                                        "UGG, UAC, UAU",
                                        "AAA, AAG, AGU"
                                    ],
                                    correctIndex: 0,
                                    explanation: "UAA (Ochre), UAG (Amber), and UGA (Opal) are non-sense stop codons recognized by release factors rather than tRNAs."
                                },
                                {
                                    question: "In eukaryotic mRNA post-transcriptional processing, the 5' cap is composed of:",
                                    options: [
                                        "Poly-adenylate tail (200-250 Adenines)",
                                        "7-methylguanosine (m7G) triphosphate linkage",
                                        "Ribosomal RNA hairpin loop",
                                        "Spliceosome ribonucleoprotein snRNP"
                                    ],
                                    correctIndex: 1,
                                    explanation: "Eukaryotic pre-mRNA is capped at its 5' end with 7-methylguanosine via an unusual 5'-to-5' triphosphate bridge to prevent exonuclease degradation."
                                },
                                {
                                    question: "Which enzyme is responsible for synthesizing ribosomal RNA (28S, 18S, and 5.8S) in eukaryotic nucleoli?",
                                    options: [
                                        "RNA Polymerase I",
                                        "RNA Polymerase II",
                                        "RNA Polymerase III",
                                        "Reverse Transcriptase"
                                    ],
                                    correctIndex: 0,
                                    explanation: "In eukaryotes: RNA Pol I transcribes major rRNAs (28S, 18S, 5.8S); RNA Pol II transcribes mRNA and snRNA; RNA Pol III transcribes tRNA and 5S rRNA."
                                },
                                {
                                    question: "A cross between a red flower (RR) and white flower (WW) yielding 100% pink flowers (RW) exemplifies:",
                                    options: [
                                        "Complete dominance",
                                        "Incomplete dominance",
                                        "Codominance",
                                        "Epistatic suppression"
                                    ],
                                    correctIndex: 1,
                                    explanation: "Incomplete dominance occurs when heterozygotes exhibit an intermediate blended phenotype (such as 4 o'clock Mirabilis jalapa flowers)."
                                }
                            ]
                        }
                    }
                ]
            }
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
