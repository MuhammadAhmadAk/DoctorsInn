/* DoctorsInn Admin Panel JavaScript */

document.addEventListener('DOMContentLoaded', function () {
    // Sidebar Mobile Toggle
    const toggleBtn = document.querySelector('.sidebar-toggle-btn');
    const sidebar = document.querySelector('.admin-sidebar');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });

        // Close sidebar on outer click on mobile
        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 991) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    }

    // Keyboard shortcut to focus search: Ctrl + / or Command + /
    const searchInput = document.querySelector('.nav-search input');
    if (searchInput) {
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                e.preventDefault();
                searchInput.focus();
            }
        });
    }
});
