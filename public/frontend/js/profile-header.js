$(window).on('load', function () {
    // Dropdown toggle on click (useful for touch screens/mobile where hover is not active)
    $(document).on('click', '.profile-avatar-trigger', function (e) {
        e.stopPropagation();
        $(this).find('.profile-dropdown-menu').toggleClass('show');
    });

    // Close dropdown when clicking outside
    $(document).on('click', function () {
        $('.profile-dropdown-menu').removeClass('show');
    });
});
