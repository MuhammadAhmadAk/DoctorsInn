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
        }, 300);
    }

    // Fast reveal on DOM ready or immediate if already interactive
    if (document.readyState === 'interactive' || document.readyState === 'complete') {
        hidePreloader();
    } else {
        document.addEventListener('DOMContentLoaded', hidePreloader, { once: true });
        // Failsafe: never block student view longer than 600ms even if slow external network assets lag
        setTimeout(hidePreloader, 600);
    }
})();
