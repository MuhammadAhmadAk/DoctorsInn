(function () {
    const preloader = document.getElementById('page-preloader');

    if (!preloader) return;

    function hidePreloader() {
        preloader.classList.add('is-hidden');
    }

    if (document.readyState === 'complete') {
        hidePreloader();
    } else {
        window.addEventListener('load', hidePreloader, { once: true });
    }
})();