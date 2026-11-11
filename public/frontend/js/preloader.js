(function () {
    const preloader = document.getElementById('page-preloader');
    if (!preloader) return;

    let isHidden = false;
    function hidePreloader() {
        if (isHidden) return;
        isHidden = true;
        preloader.classList.add('is-hidden');
        setTimeout(() => {
            if (preloader.parentNode) {
                preloader.style.display = 'none';
            }
        }, 160);
    }

    if (document.readyState === 'interactive' || document.readyState === 'complete') {
        hidePreloader();
    } else {
        document.addEventListener('DOMContentLoaded', hidePreloader, { once: true });
        setTimeout(hidePreloader, 180);
    }
})();
