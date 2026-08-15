<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar - Visible on Desktop and Mobile) -->
    <button id="sidebarToggleTop" class="btn btn-light rounded-circle mr-3 border-0 shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; color: #475569; background: #f8fafc;" title="Toggle Sidebar Navigation">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Live Website Button -->
        <li class="nav-item mx-1 align-self-center mr-2">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm rounded-pill font-weight-bold px-3 d-flex align-items-center" style="background: rgba(234, 88, 12, 0.12); color: #f97316; border: 1px solid rgba(249, 115, 22, 0.3);" title="Visit Live Website">
                <i class="fas fa-globe mr-2"></i>
                <span class="d-none d-md-inline">Live Website</span>
                <i class="fas fa-external-link-alt ml-2 small" style="font-size: 10px; opacity: 0.8;"></i>
            </a>
        </li>

        <!-- Quick Actions Dropdown -->
        @canany(['competitions.create', 'teams.create', 'matches.create', 'matches.live-center'])
        <li class="nav-item dropdown no-arrow mx-1 align-self-center mr-2">
            <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle shadow-sm" type="button" id="quickActionBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-plus-circle mr-1"></i> Quick Action
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="quickActionBtn">
                    @can('competitions.create')
                    <a class="dropdown-item" href="{{ route('admin.competitions.create') }}"><i class="fas fa-trophy text-primary mr-2"></i>Create Competition</a>
                    @endcan
                    @can('teams.create')
                    <a class="dropdown-item" href="{{ route('admin.teams.create') }}"><i class="fas fa-shield-alt text-success mr-2"></i>Register Team</a>
                    @endcan
                    @can('matches.create')
                    <a class="dropdown-item" href="{{ route('admin.matches.create') }}"><i class="fas fa-calendar-plus text-info mr-2"></i>Schedule Match</a>
                    @endcan
                    @can('matches.live-center')
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger font-weight-bold" href="{{ route('admin.matches.live-center') }}"><i class="fas fa-broadcast-tower text-danger mr-2"></i>Live Match Center</a>
                    @endcan
                </div>
            </div>
        </li>
        @endcanany

        @php
            $topbarLiveMatches = \App\Models\GameMatch::with(['homeTeam', 'awayTeam', 'competition'])
                ->where('status', 'live')
                ->latest('started_at')
                ->take(5)
                ->get();
        @endphp

        <!-- Notifications Dropdown -->
        <li class="nav-item dropdown no-arrow mx-1" id="adminNotificationsDropdownWrapper">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter" id="adminNotificationCounter" style="display: {{ $topbarLiveMatches->count() > 0 ? 'inline-block' : 'none' }};">
                    {{ $topbarLiveMatches->count() }}
                </span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown" style="min-width: 320px;">
                <h6 class="dropdown-header bg-primary border-0 d-flex justify-content-between align-items-center">
                    <span>Live Match Alerts</span>
                    <div>
                        <button type="button" class="btn btn-sm btn-link text-white p-0 mr-2" style="font-size: 0.7rem; text-decoration: underline;" onclick="clearAllNotifications(); event.stopPropagation();">Clear All</button>
                        <span class="badge badge-light text-primary" style="font-size: 0.7rem;">Real-Time</span>
                    </div>
                </h6>
                <div id="adminNotificationsList">
                    @forelse($topbarLiveMatches as $liveMatch)
                        <div class="dropdown-item d-flex align-items-center justify-content-between notification-item" id="notif-match-{{ $liveMatch->id }}" data-notif-id="match_{{ $liveMatch->id }}">
                            <a href="{{ route('admin.matches.show', $liveMatch->id) }}" onclick="dismissNotification('match_{{ $liveMatch->id }}');" class="d-flex align-items-center text-decoration-none text-dark flex-grow-1 mr-2">
                                <div class="mr-3">
                                    <div class="icon-circle bg-danger text-white animate-pulse">
                                        <i class="fas fa-broadcast-tower"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-danger font-weight-bold">🔴 LIVE NOW ({{ $liveMatch->home_score }} - {{ $liveMatch->away_score }})</div>
                                    <span class="font-weight-bold" style="font-size: 0.85rem;">{{ $liveMatch->homeTeam->name ?? 'Home' }} vs {{ $liveMatch->awayTeam->name ?? 'Away' }}</span>
                                    <div class="small text-muted">{{ $liveMatch->competition->name ?? 'Competition' }}</div>
                                </div>
                            </a>
                            <button type="button" class="btn btn-sm btn-light text-muted p-1 rounded-circle" title="Dismiss" onclick="dismissNotification('match_{{ $liveMatch->id }}'); event.stopPropagation();" style="width: 24px; height: 24px; line-height: 1;">
                                &times;
                            </button>
                        </div>
                    @empty
                        <div id="noNotificationsMsg" class="text-center py-3 text-muted small">
                            <i class="fas fa-bell-slash mr-1"></i> No active notifications
                        </div>
                    @endforelse
                </div>
                <a class="dropdown-item text-center small text-primary font-weight-bold" href="{{ route('admin.matches.live-center') }}" onclick="clearAllNotifications();">
                    <i class="fas fa-broadcast-tower mr-1 text-danger"></i> View All Live Matches
                </a>
            </div>
        </li>

        <!-- Floating Live Toast Alert Container -->
        <div id="realtimeToastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 99999; width: 340px; pointer-events: none;"></div>

        <script>
            function updateNotifBadge() {
                var listEl = document.getElementById('adminNotificationsList');
                var counterEl = document.getElementById('adminNotificationCounter');
                if (!listEl || !counterEl) return;
                
                var items = listEl.querySelectorAll('.notification-item');
                var count = items.length;
                
                if (count > 0) {
                    counterEl.innerText = count;
                    counterEl.style.display = 'inline-block';
                } else {
                    counterEl.innerText = '0';
                    counterEl.style.display = 'none';
                    if (!document.getElementById('noNotificationsMsg')) {
                        listEl.innerHTML = '<div id="noNotificationsMsg" class="text-center py-3 text-muted small"><i class="fas fa-bell-slash mr-1"></i> No active notifications</div>';
                    }
                }
            }

            function dismissNotification(notifId) {
                var el = document.querySelector('[data-notif-id="' + notifId + '"]');
                if (el) {
                    el.style.transition = 'all 0.3s ease';
                    el.style.opacity = '0';
                    el.style.transform = 'translateX(20px)';
                    setTimeout(function () {
                        el.remove();
                        updateNotifBadge();
                    }, 300);
                }
                // Save dismissed state in sessionStorage so user doesn't see it again during session
                try {
                    var dismissed = JSON.parse(sessionStorage.getItem('dismissed_notifs') || '[]');
                    if (!dismissed.includes(notifId)) {
                        dismissed.push(notifId);
                        sessionStorage.setItem('dismissed_notifs', JSON.stringify(dismissed));
                    }
                } catch(e){}
            }

            function clearAllNotifications() {
                var listEl = document.getElementById('adminNotificationsList');
                if (listEl) {
                    var items = listEl.querySelectorAll('.notification-item');
                    items.forEach(function(item) {
                        var id = item.getAttribute('data-notif-id');
                        if (id) dismissNotification(id);
                    });
                    listEl.innerHTML = '<div id="noNotificationsMsg" class="text-center py-3 text-muted small"><i class="fas fa-bell-slash mr-1"></i> No active notifications</div>';
                    updateNotifBadge();
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                // Filter out already dismissed items on page load
                try {
                    var dismissed = JSON.parse(sessionStorage.getItem('dismissed_notifs') || '[]');
                    dismissed.forEach(function (id) {
                        var el = document.querySelector('[data-notif-id="' + id + '"]');
                        if (el) el.remove();
                    });
                    updateNotifBadge();
                } catch(e){}

                if (window.Echo && typeof window.Echo.channel === 'function') {
                    window.Echo.channel('admin-notifications')
                        .listen('.AdminLiveMatchNotification', function (data) {
                            var notif = data.notification || data;
                            var notifId = notif.id || ('match_' + (notif.match_id || Date.now()));
                            var matchUrl = notif.url || ('/admin/matches/' + notif.match_id);

                            // 1. Remove empty placeholder if present
                            var noMsg = document.getElementById('noNotificationsMsg');
                            if (noMsg) noMsg.remove();

                            // 2. Prepend item to dropdown with dismiss button
                            var listEl = document.getElementById('adminNotificationsList');
                            if (listEl) {
                                var existing = document.querySelector('[data-notif-id="' + notifId + '"]');
                                if (existing) existing.remove();

                                var itemHtml = '<div class="dropdown-item d-flex align-items-center justify-content-between notification-item bg-light border-left-danger" data-notif-id="' + notifId + '" style="animation: fadeIn 0.3s ease;">' +
                                    '<a href="' + matchUrl + '" onclick="dismissNotification(\'' + notifId + '\');" class="d-flex align-items-center text-decoration-none text-dark flex-grow-1 mr-2">' +
                                        '<div class="mr-3">' +
                                            '<div class="icon-circle bg-danger text-white animate-pulse">' +
                                                '<i class="fas fa-broadcast-tower"></i>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div>' +
                                            '<div class="small text-danger font-weight-bold">⚡ JUST STARTED LIVE</div>' +
                                            '<span class="font-weight-bold text-dark" style="font-size: 0.85rem;">' + (notif.home_team || 'Home') + ' vs ' + (notif.away_team || 'Away') + '</span>' +
                                            '<div class="small text-muted">' + (notif.competition || 'Handball') + '</div>' +
                                        '</div>' +
                                    '</a>' +
                                    '<button type="button" class="btn btn-sm btn-light text-muted p-1 rounded-circle" title="Dismiss" onclick="dismissNotification(\'' + notifId + '\'); event.stopPropagation();" style="width: 24px; height: 24px; line-height: 1;">' +
                                        '&times;' +
                                    '</button>' +
                                '</div>';
                                listEl.insertAdjacentHTML('afterbegin', itemHtml);
                                updateNotifBadge();
                            }

                            // 3. Show Interactive Toast Popup
                            var toastContainer = document.getElementById('realtimeToastContainer');
                            if (toastContainer) {
                                var toastId = 'toast_' + Date.now();
                                var toastHtml = '<div id="' + toastId + '" class="alert shadow-lg text-white border-0 d-flex align-items-center justify-content-between p-3 mb-2" ' +
                                    'style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-left: 5px solid #ef4444 !important; border-radius: 12px; pointer-events: auto; animation: slideInRight 0.3s ease-out; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.4);">' +
                                    '<div class="d-flex align-items-center">' +
                                        '<div class="mr-3">' +
                                            '<span class="badge badge-danger p-2 rounded-circle animate-pulse"><i class="fas fa-broadcast-tower fa-lg"></i></span>' +
                                        '</div>' +
                                        '<div>' +
                                            '<div class="font-weight-bold text-danger text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Live Match Alert</div>' +
                                            '<div class="font-weight-bold" style="font-size: 0.9rem;">' + (notif.home_team || 'Home') + ' vs ' + (notif.away_team || 'Away') + '</div>' +
                                            '<div class="small text-light opacity-75">' + (notif.competition || '') + ' is live now</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="ml-3 d-flex flex-column align-items-end">' +
                                        '<a href="' + matchUrl + '" onclick="dismissNotification(\'' + notifId + '\');" class="btn btn-danger btn-sm font-weight-bold mb-1 shadow-sm px-2 py-1" style="font-size: 0.75rem;">' +
                                            '<i class="fas fa-eye fa-xs mr-1"></i> Details' +
                                        '</a>' +
                                        '<button type="button" class="btn btn-link text-light p-0" onclick="document.getElementById(\'' + toastId + '\').remove();" style="font-size: 0.75rem; text-decoration: none;">&times;</button>' +
                                    '</div>' +
                                '</div>';
                                toastContainer.insertAdjacentHTML('beforeend', toastHtml);

                                setTimeout(function () {
                                    var el = document.getElementById(toastId);
                                    if (el) {
                                        el.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                                        el.style.opacity = '0';
                                        el.style.transform = 'translateX(100%)';
                                        setTimeout(function() { el.remove(); }, 500);
                                    }
                                }, 8000);
                            }
                        });
                }
            });
        </script>

        <div class="topbar-divider d-none d-sm-block"></div>

        @php
            $authUser = auth('admin')->user() ?? auth()->user();
            $authAvatarUrl = asset('backend/img/undraw_profile.svg');
            if (!empty($authUser?->admin?->image) && $authUser->admin->image !== 'defaults/avatar.png') {
                $authAvatarUrl = filter_var($authUser->admin->image, FILTER_VALIDATE_URL)
                    ? $authUser->admin->image
                    : asset('storage/' . $authUser->admin->image);
            }
        @endphp
        <!-- User Profile -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-400 small font-weight-bold">{{ $authUser?->name ?? 'Admin' }}</span>
                <img class="img-profile rounded-circle" src="{{ $authAvatarUrl }}" style="width: 32px; height: 32px; object-fit: cover; background: #1e293b; border: 1px solid rgba(234, 88, 12, 0.4);">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile</a>
                <a class="dropdown-item" href="{{ route('admin.activity-logs.index') }}"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i> Logout</a>
                <form id="admin-logout-form" action="{{ route('admin.auth.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
