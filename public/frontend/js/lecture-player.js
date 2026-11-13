/**
 * DoctorsInn Secure Lecture Player
 * Video.js + HLS (media source) with signed URLs, resume, progress sync,
 * manual/auto quality, keyboard shortcuts and graceful error recovery.
 */
(function () {
    'use strict';

    if (window.LecturePlayer) {
        return;
    }

    const state = {
        player: null,
        lecture: null,
        topicId: null,
        callbacks: {},
        open: false,
        pendingResume: null,
        resumeFrom: 0,
        lastSavedAt: 0,
        lastTimeTick: 0,
        saving: false,
        completedNotified: false,
        processingTimer: null,
        bufferTimer: null,
        qualityReady: false
    };

    const els = {};

    function $(id) {
        return document.getElementById(id);
    }

    function cacheElements() {
        els.container = $('lecture-player-container');
        els.title = $('lecture-player-title');
        els.subtitle = $('lecture-player-subtitle');
        els.quality = $('lecture-quality-select');
        els.speed = $('lecture-speed-select');
        els.loading = $('lecture-player-loading');
        els.error = $('lecture-player-error');
        els.errorText = $('lecture-error-text');
        els.retry = $('lecture-retry-btn');
        els.processing = $('lecture-player-processing');
        els.processingText = $('lecture-processing-text');
        els.processingBar = $('lecture-processing-bar');
        els.percent = $('lecture-percent-label');
        els.resume = $('lecture-resume-label');
        els.prev = $('lecture-prev-btn');
        els.next = $('lecture-next-btn');
    }

    function endpoints() {
        return window.lectureEndpoints || {};
    }

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return (endpoints().csrf) || (meta ? meta.content : '');
    }

    function lectureUrl(suffix) {
        const base = (endpoints().base || '').replace(/\/+$/, '');
        return base + '/' + encodeURIComponent(state.lecture.id) + '/' + suffix;
    }

    function formatTime(seconds) {
        seconds = Math.max(0, Math.floor(seconds || 0));
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;
        if (h > 0) {
            return h + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }
        return m + ':' + String(s).padStart(2, '0');
    }

    function show(el, visible) {
        if (!el) return;
        el.classList.toggle('d-none', !visible);
    }

    function setLoading(visible, text) {
        if (!els.loading) return;
        if (text) {
            const label = els.loading.querySelector('[data-loading-text]');
            if (label) label.textContent = text;
        }
        show(els.loading, visible);
    }

    function showError(message) {
        setLoading(false);
        show(els.processing, false);
        if (els.errorText) els.errorText.textContent = message;
        show(els.error, true);
    }

    function hideError() {
        show(els.error, false);
    }

    function showProcessing(lecture) {
        setLoading(false);
        hideError();
        if (!els.processing) return;
        const pct = Math.max(0, Math.min(100, lecture.progress || 0));
        if (els.processingText) {
            els.processingText.textContent = lecture.error
                ? 'Processing failed: ' + lecture.error
                : (lecture.status === 'queued'
                    ? 'This lecture is queued for processing. It will unlock automatically.'
                    : 'This lecture is being prepared for playback (' + pct + '%).');
        }
        if (els.processingBar) els.processingBar.style.width = pct + '%';
        show(els.processing, true);
    }

    function initPlayer() {
        if (state.player || !window.videojs) return;

        state.player = window.videojs('lecture-video-player', {
            controls: true,
            autoplay: false,
            preload: 'auto',
            fluid: true,
            aspectRatio: '16:9',
            playbackRates: [0.5, 0.75, 1, 1.25, 1.5, 1.75, 2],
            html5: {
                vhs: {
                    overrideNative: true,
                    bandwidth: 500000,
                    maxBufferLength: 40,
                    maxMaxBufferLength: 120,
                    backBufferLength: 30,
                    useBandwidthFromLocalStorage: true
                }
            }
        });

        const player = state.player;

        player.on('waiting', function () {
            window.clearTimeout(state.bufferTimer);
            state.bufferTimer = window.setTimeout(function () {
                if (state.open && state.player && !state.player.paused() && state.player.currentTime() > 0.5) {
                    setLoading(true, 'Buffering…');
                }
            }, 1200);
        });
        player.on('canplay', function () {
            window.clearTimeout(state.bufferTimer);
            setLoading(false);
            hideError();
        });
        player.on('playing', function () {
            window.clearTimeout(state.bufferTimer);
            setLoading(false);
        });
        player.on('pause', function () { saveProgress(false); });
        player.on('ended', function () {
            saveProgress(true);
            notifyCompleted();
        });
        player.on('timeupdate', onTimeUpdate);
        player.on('error', onPlayerError);

        player.on('loadedmetadata', function () {
            if (state.pendingResume && state.pendingResume > 1) {
                try {
                    player.currentTime(Math.min(state.pendingResume, Math.max(0, player.duration() - 2)));
                    if (els.resume) {
                        els.resume.textContent = 'Resumed at ' + formatTime(state.pendingResume);
                    }
                } catch (e) { /* seek unsupported */ }
            }
            state.pendingResume = null;
        });

        setupQualitySelector();

        els.speed?.addEventListener('change', function () {
            const rate = parseFloat(els.speed.value) || 1;
            try {
                player.playbackRate(rate);
            } catch (e) { /* ignore */ }
        });

        els.retry?.addEventListener('click', function () {
            hideError();
            requestPlaybackUrl();
        });

        document.querySelectorAll('[data-lecture-skip]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (!state.player) return;
                const delta = parseInt(btn.dataset.lectureSkip, 10) || 0;
                skip(delta);
            });
        });

        els.prev?.addEventListener('click', function () {
            if (typeof state.callbacks.onPrev === 'function') state.callbacks.onPrev();
        });
        els.next?.addEventListener('click', function () {
            if (typeof state.callbacks.onNext === 'function') state.callbacks.onNext();
        });

        document.addEventListener('keydown', onKeydown, true);
    }

    function setupQualitySelector() {
        if (!state.player || !els.quality || state.qualityReady) return;
        state.qualityReady = true;

        const player = state.player;
        let levels = null;
        try {
            levels = player.qualityLevels();
        } catch (e) {
            show(els.quality, false);
            return;
        }
        if (!levels) {
            show(els.quality, false);
            return;
        }

        function rebuild() {
            const current = els.quality.value;
            const list = levels.levels_ || levels.levels || [];
            const hasLevels = list.some(function (level) { return Boolean(level.height); });
            els.quality.innerHTML = '<option value="auto">Auto</option>';
            list.forEach(function (level, index) {
                if (!level.height) return;
                const option = document.createElement('option');
                option.value = String(index);
                option.textContent = level.height + 'p';
                els.quality.appendChild(option);
            });
            if (current && els.quality.querySelector('option[value="' + current + '"]')) {
                els.quality.value = current;
            }
            show(els.quality, hasLevels);
        }

        levels.on('addqualitylevel', rebuild);
        rebuild();

        els.quality.addEventListener('change', function () {
            const value = els.quality.value;
            const list = levels.levels_ || levels.levels || [];
            if (value === 'auto') {
                list.forEach(function (level) { level.enabled = true; });
            } else {
                list.forEach(function (level, index) {
                    level.enabled = String(index) === value;
                });
            }
        });
    }

    function onKeydown(event) {
        if (!state.open || !state.player) return;
        const tag = (event.target && event.target.tagName) || '';
        if (/^(INPUT|TEXTAREA|SELECT)$/.test(tag) || (event.target && event.target.isContentEditable)) {
            return;
        }

        switch (event.key) {
            case ' ':
            case 'k':
                event.preventDefault();
                state.player.paused() ? state.player.play() : state.player.pause();
                break;
            case 'ArrowLeft':
                event.preventDefault();
                skip(-10);
                break;
            case 'ArrowRight':
                event.preventDefault();
                skip(10);
                break;
            case 'ArrowUp':
                event.preventDefault();
                state.player.volume(Math.min(1, state.player.volume() + 0.1));
                break;
            case 'ArrowDown':
                event.preventDefault();
                state.player.volume(Math.max(0, state.player.volume() - 0.1));
                break;
            case 'm':
                state.player.muted(!state.player.muted());
                break;
            case 'f':
                state.player.isFullscreen() ? state.player.exitFullscreen() : state.player.requestFullscreen();
                break;
            default:
                break;
        }
    }

    function skip(delta) {
        if (!state.player) return;
        const duration = state.player.duration() || 0;
        let target = (state.player.currentTime() || 0) + delta;
        target = Math.max(0, Math.min(duration > 0 ? duration - 0.5 : target, target));
        try {
            state.player.currentTime(target);
        } catch (e) { /* ignore */ }
    }

    function onTimeUpdate() {
        if (!state.player) return;
        const position = state.player.currentTime() || 0;
        const duration = state.player.duration() || (state.lecture && state.lecture.duration) || 0;

        const now = Date.now();
        if (now - state.lastTimeTick > 500) {
            state.lastTimeTick = now;
            const percent = duration > 0 ? Math.min(100, Math.round((position / duration) * 100)) : 0;
            if (els.percent) els.percent.textContent = percent + '% watched';
        }

        if (now - state.lastSavedAt > 15000) {
            saveProgress(false);
        }
    }

    function saveProgress(immediate) {
        if (!state.open || !state.lecture || !state.player || state.lecture.status !== 'ready') return;
        if (state.saving) return;

        const position = Math.floor(state.player.currentTime() || 0);
        const duration = Math.floor(state.player.duration() || state.lecture.duration || 0);
        if (duration <= 0) return;

        const now = Date.now();
        if (!immediate && now - state.lastSavedAt < 10000) return;
        state.lastSavedAt = now;
        state.saving = true;

        fetch(lectureUrl('progress'), {
            method: 'POST',
            keepalive: true,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken(),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ position: position, duration: duration })
        })
            .then(function (res) { return res.ok ? res.json() : null; })
            .then(function (data) {
                if (!data) return;
                if (els.percent) els.percent.textContent = data.percent + '% watched';
                if (data.completed) notifyCompleted();
            })
            .catch(function () { /* progress retried on next tick */ })
            .finally(function () { state.saving = false; });
    }

    function notifyCompleted() {
        if (state.completedNotified) return;
        state.completedNotified = true;
        if (typeof state.callbacks.onCompleted === 'function') {
            state.callbacks.onCompleted();
        }
    }

    function onPlayerError() {
        if (!state.player) return;
        const error = state.player.error();
        let message = 'Playback failed. The secure link may have expired.';
        if (error) {
            if (error.code === 2 || error.code === 3) {
                message = 'The video stream was interrupted. Check your connection and retry.';
            } else if (error.code === 4) {
                message = 'This video format could not be played in your browser. Please retry or use a supported browser.';
            }
        }
        showError(message);
    }

    function requestPlaybackUrl() {
        if (!state.lecture) return;
        const requestLectureId = state.lecture.id;
        clearProcessingTimer();
        setLoading(true, 'Preparing secure stream…');
        hideError();
        show(els.processing, false);

        fetch(lectureUrl('playback-url'), {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken(),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(function (res) {
                return res.json().catch(function () { return {}; }).then(function (data) {
                    return { ok: res.ok, status: res.status, data: data };
                });
            })
            .then(function (result) {
                if (!state.open || !state.lecture || state.lecture.id !== requestLectureId) return;
                if (result.status === 409) {
                    state.lecture.status = result.data.status || 'processing';
                    showProcessing({ status: state.lecture.status, progress: 0, error: null });
                    clearProcessingTimer();
                    state.processingTimer = window.setTimeout(function () {
                        if (state.open && state.lecture && state.lecture.id === requestLectureId) {
                            requestPlaybackUrl();
                        }
                    }, 12000);
                    return;
                }
                if (!result.ok) {
                    showError(result.data.message || 'You are not authorized to watch this lecture.');
                    return;
                }
                playSignedUrl(result.data.url, result.data.type);
            })
            .catch(function () {
                if (!state.open || !state.lecture || state.lecture.id !== requestLectureId) return;
                showError('Network error while preparing playback. Please retry.');
            });
    }

    function playSignedUrl(url, type) {
        if (!state.player) {
            showError('Player library failed to load. Refresh the page and retry.');
            return;
        }

        state.pendingResume = state.resumeFrom;
        state.completedNotified = Boolean(state.callbacks.alreadyCompleted);

        try {
            state.player.src({ src: url, type: type || 'application/x-mpegURL' });
            const promise = state.player.play();
            if (promise && promise.catch) {
                promise.catch(function () { setLoading(false); });
            }
        } catch (e) {
            showError('Could not start the video player.');
        }
    }

    function clearProcessingTimer() {
        if (state.processingTimer) {
            window.clearTimeout(state.processingTimer);
            state.processingTimer = null;
        }
    }

    function setHeader(lecture) {
        const isHls = lecture.hls !== false;
        if (els.title) els.title.textContent = lecture.title || 'Lecture';
        if (els.subtitle) {
            const qualities = lecture.qualities && lecture.qualities.length;
            els.subtitle.textContent = qualities
                ? lecture.qualities.join(' / ')
                : (isHls ? 'Auto quality' : '');
        }
        if (els.quality) show(els.quality, lecture.status === 'ready' && isHls);
        if (els.percent) els.percent.textContent = '0% watched';
        if (els.resume) els.resume.textContent = '';
    }

    function open(lecture, options) {
        if (!lecture) {
            close();
            return;
        }

        cacheElements();
        initPlayer();
        window.clearTimeout(state.bufferTimer);

        if (state.player) {
            try {
                state.player.pause();
                state.player.reset();
            } catch (e) { /* ignore */ }
        }

        state.open = true;
        state.lecture = lecture;
        state.topicId = options.topicId;
        state.callbacks = options;
        state.resumeFrom = Math.max(0, Number(options.resume) || 0);
        state.lastSavedAt = 0;
        state.lastTimeTick = 0;
        state.completedNotified = Boolean(options.alreadyCompleted);

        show(els.container, true);
        hideError();
        setHeader(lecture);

        if (lecture.status !== 'ready') {
            showProcessing(lecture);
            requestPlaybackUrl();
            return;
        }

        if (state.resumeFrom > 3 && els.resume) {
            els.resume.textContent = 'Resuming at ' + formatTime(state.resumeFrom);
        }

        requestPlaybackUrl();
    }

    function close() {
        clearProcessingTimer();
        window.clearTimeout(state.bufferTimer);
        if (state.open) {
            saveProgress(true);
        }
        state.open = false;
        if (state.player) {
            try {
                state.player.pause();
                state.player.reset();
            } catch (e) { /* ignore */ }
        }
        state.lecture = null;
        cacheElements();
        show(els.container, false);
        setLoading(false);
        show(els.processing, false);
        hideError();
    }

    function pause() {
        if (state.player) {
            try { state.player.pause(); } catch (e) { /* ignore */ }
        }
    }

    function flushProgress() {
        saveProgress(true);
    }

    window.addEventListener('pagehide', function () {
        if (state.open) saveProgress(true);
    });
    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'hidden' && state.open) saveProgress(true);
    });

    window.LecturePlayer = {
        open: open,
        close: close,
        pause: pause,
        saveProgress: flushProgress,
        isOpen: function () { return state.open; }
    };
})();
