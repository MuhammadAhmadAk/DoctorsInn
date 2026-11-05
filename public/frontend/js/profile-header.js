/**
 * DoctorsInn - Header Profile Dropdown Interactive Behavior
 * Instant execution with event delegation (no window.load delay)
 */
(function () {
    function initHeaderProfileDropdown() {
        // Handle click on profile button or trigger
        document.addEventListener('click', function (e) {
            var trigger = e.target.closest('#headerUserMenuBtn, .header-profile-avatar-btn, .header-profile-btn, .profile-avatar-trigger');
            
            if (trigger) {
                e.preventDefault();
                e.stopPropagation();

                var dropdown = trigger.closest('.header-user-dropdown, .dropdown, .profile-avatar-trigger');
                if (!dropdown) return;

                var menu = dropdown.querySelector('.header-profile-menu, .profile-dropdown-menu, .dropdown-menu');
                if (!menu) return;

                var isOpen = menu.classList.contains('show');

                // Close any other open dropdowns first
                closeAllHeaderDropdowns();

                if (!isOpen) {
                    menu.classList.add('show');
                    dropdown.classList.add('show');
                    trigger.setAttribute('aria-expanded', 'true');
                }
                return;
            }

            // If click was inside the dropdown menu itself, let links work normally
            if (e.target.closest('.header-profile-menu, .profile-dropdown-menu')) {
                return;
            }

            // Clicking anywhere outside closes dropdowns
            closeAllHeaderDropdowns();
        });

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                closeAllHeaderDropdowns();
            }
        });
    }

    function closeAllHeaderDropdowns() {
        document.querySelectorAll('.header-profile-menu.show, .profile-dropdown-menu.show').forEach(function (m) {
            m.classList.remove('show');
        });
        document.querySelectorAll('.header-user-dropdown.show, .dropdown.show').forEach(function (d) {
            d.classList.remove('show');
        });
        document.querySelectorAll('#headerUserMenuBtn, .header-profile-avatar-btn, .header-profile-btn, .profile-avatar-trigger').forEach(function (btn) {
            btn.setAttribute('aria-expanded', 'false');
        });
    }

    // Run immediately if DOM ready, otherwise wait for DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeaderProfileDropdown);
    } else {
        initHeaderProfileDropdown();
    }
})();
