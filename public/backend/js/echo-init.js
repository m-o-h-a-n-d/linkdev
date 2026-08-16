/**
 * Handball Hub - Laravel Echo & Reverb WebSocket Initializer
 * Automatically configures Pusher and Laravel Echo from document meta tags.
 */
(function () {
    'use strict';

    if (typeof Pusher !== 'undefined') {
        window.Pusher = Pusher;
    }

    function getMeta(name, fallback) {
        var meta = document.querySelector('meta[name="' + name + '"]');
        return meta ? meta.getAttribute('content') : fallback;
    }

    var key = getMeta('reverb-key', 'ebblun6tzqjoj7nqj3p3');
    var host = getMeta('reverb-host', window.location.hostname || '127.0.0.1');
    if (host === 'localhost') {
        host = '127.0.0.1';
    }
    var port = parseInt(getMeta('reverb-port', '8085'), 10) || 8085;
    var scheme = getMeta('reverb-scheme', (window.location.protocol === 'https:' ? 'https' : 'http'));
    var useTLS = scheme === 'https';

    var EchoConstructor = (typeof Echo === 'function')
        ? Echo
        : (window.Echo && window.Echo.default ? window.Echo.default : (typeof window.Echo === 'function' ? window.Echo : null));

    if (EchoConstructor && window.Pusher) {
        window.Echo = new EchoConstructor({
            broadcaster: 'reverb',
            key: key,
            wsHost: host,
            wsPort: port,
            wssPort: port,
            forceTLS: useTLS,
            encrypted: useTLS,
            disableStats: true,
            enabledTransports: useTLS ? ['wss', 'ws'] : ['ws', 'wss'],
        });

        if (window.Echo.connector && window.Echo.connector.pusher) {
            window.Echo.connector.pusher.connection.bind('connected', function () {
                var badge = document.querySelector('.badge-success i.fa-bolt')?.parentElement;
                if (badge) {
                    badge.innerHTML = '<i class="fas fa-bolt text-warning mr-1 animate-pulse"></i> Real-Time Connected';
                    badge.className = 'badge badge-success px-3 py-2 mr-3 font-weight-bold shadow-sm d-flex align-items-center';
                }
            });

            window.Echo.connector.pusher.connection.bind('unavailable', function () {
                var badge = document.querySelector('.badge-success i.fa-bolt')?.parentElement || document.querySelector('.badge-warning i.fa-bolt')?.parentElement;
                if (badge) {
                    badge.innerHTML = '<i class="fas fa-bolt text-dark mr-1"></i> AJAX Live Active (Reverb Offline)';
                    badge.className = 'badge badge-warning text-dark px-3 py-2 mr-3 font-weight-bold shadow-sm d-flex align-items-center';
                }
            });
        }
    }
})();
