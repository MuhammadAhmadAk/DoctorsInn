document.addEventListener('DOMContentLoaded', () => {
    const itemsPerPage = 6;
    const courseCards = Array.from(document.querySelectorAll('.th-course-row.columns-3 > .th-course-single'));
    const totalPages = Math.ceil(courseCards.length / itemsPerPage);
    let currentPage = 1;

    if (courseCards.length === 0) return;

    function showPage(page) {
        currentPage = page;
        courseCards.forEach((card, index) => {
            card.classList.toggle('d-none', index < (page - 1) * itemsPerPage || index >= page * itemsPerPage);
        });

        document.querySelectorAll('.th-pagination .page-num').forEach(button => {
            button.classList.toggle('active', Number(button.dataset.page) === page);
        });
        document.querySelector('.th-pagination .prev-btn')?.classList.toggle('disabled', page === 1);
        document.querySelector('.th-pagination .next-btn')?.classList.toggle('disabled', page === totalPages);

        if (typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh();
    }

    function scrollToCourses() {
        const courseSection = document.getElementById('course-sec');
        if (courseSection) {
            window.scrollTo({ top: courseSection.getBoundingClientRect().top + window.scrollY - 100, behavior: 'smooth' });
        }
    }

    document.querySelector('.th-pagination')?.addEventListener('click', event => {
        const pageButton = event.target.closest('.page-num');
        const previousButton = event.target.closest('.prev-btn');
        const nextButton = event.target.closest('.next-btn');
        let targetPage = currentPage;

        if (pageButton) targetPage = Number(pageButton.dataset.page);
        if (previousButton) targetPage -= 1;
        if (nextButton) targetPage += 1;
        if (!pageButton && !previousButton && !nextButton) return;

        event.preventDefault();
        if (targetPage < 1 || targetPage > totalPages || targetPage === currentPage) return;

        showPage(targetPage);
        scrollToCourses();
    });

    showPage(1);
});
