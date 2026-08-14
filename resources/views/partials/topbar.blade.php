<!-- Topbar Header -->
<header class="topbar bg-white border-bottom sticky-top py-2 px-3 px-md-4" style="z-index:1035;">
    <div class="d-flex align-items-center justify-content-between gap-3">

        {{-- Left: Sidebar toggle + Page title --}}
        <div class="d-flex align-items-center gap-3 min-w-0">
            <button type="button"
                    class="btn btn-light border-0 p-2 d-none d-md-none d-lg-none align-items-center justify-content-center rounded-3 shadow-none flex-shrink-0"
                    id="topbarSidebarToggle"
                    title="Toggle Sidebar (Ctrl+B)"
                    style="display: none !important;">
                <i class="bi bi-list icon-lg text-dark"></i>
            </button>

            {{-- Return to Recent Page Button --}}
            <button type="button"
                    class="btn btn-sm btn-outline-secondary border d-flex align-items-center gap-1.5 px-2.5 py-1 rounded-3 shadow-none flex-shrink-0"
                    id="topbarReturnBtn"
                    onclick="if (document.referrer && document.referrer !== window.location.href) { window.history.back(); } else { window.location.href='{{ url()->previous() }}'; }"
                    title="Return to Recent Page">
                <i class="bi bi-arrow-left icon-sm"></i>
                <span class="d-none d-sm-inline small fw-semibold">Return</span>
            </button>

            {{-- Dynamic page title based on current route --}}
            <div class="d-none d-sm-flex align-items-center gap-2 min-w-0">
                @php
                    $pageInfo = match(true) {
                        request()->routeIs('dashboard')          => ['icon' => 'bi-speedometer2',          'label' => 'Dashboard',      'color' => '#4f46e5'],
                        request()->routeIs('students.index')     => ['icon' => 'bi-people-fill',           'label' => 'Student Directory','color' => '#0891b2'],
                        request()->routeIs('students.create')    => ['icon' => 'bi-person-plus-fill',      'label' => 'Add Student',    'color' => '#059669'],
                        request()->routeIs('students.edit')      => ['icon' => 'bi-pencil-square',         'label' => 'Edit Student',   'color' => '#d97706'],
                        request()->routeIs('students.show')      => ['icon' => 'bi-person-lines-fill',     'label' => 'Student Profile','color' => '#7c3aed'],
                        request()->routeIs('students.honor-roll')=> ['icon' => 'bi-trophy-fill',           'label' => 'Honor Roll',     'color' => '#ca8a04'],
                        request()->routeIs('courses.*')          => ['icon' => 'bi-book-fill',             'label' => 'Courses',        'color' => '#4f46e5'],
                        request()->routeIs('subjects.*')         => ['icon' => 'bi-journal-bookmark-fill', 'label' => 'Subjects',       'color' => '#7c3aed'],
                        request()->routeIs('semesters.*')        => ['icon' => 'bi-calendar3',             'label' => 'Semesters',      'color' => '#0891b2'],
                        request()->routeIs('enrollments.*')      => ['icon' => 'bi-person-check-fill',     'label' => 'Enrollments',    'color' => '#059669'],
                        request()->routeIs('grades.*')           => ['icon' => 'bi-journal-richtext',      'label' => 'Grades',         'color' => '#d97706'],
                        request()->routeIs('activity-logs.*')    => ['icon' => 'bi-journal-text',          'label' => 'Activity Logs',  'color' => '#475569'],
                        default                                  => ['icon' => 'bi-mortarboard-fill',       'label' => 'StudentApp',     'color' => '#4f46e5'],
                    };
                @endphp
                <i class="bi {{ $pageInfo['icon'] }} icon-md" style="color: {{ $pageInfo['color'] }};"></i>
                <span class="fw-semibold text-dark text-truncate" style="font-size:.9rem;">{{ $pageInfo['label'] }}</span>
            </div>
        </div>

        {{-- Right: System badge + User info (compact) --}}
        <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <span class="badge bg-indigo-subtle text-primary fw-semibold px-2 py-1 rounded-pill small d-none d-md-inline-flex align-items-center gap-1">
                <i class="bi bi-shield-check me-1"></i> SMS
            </span>
            @auth
            <div class="d-flex align-items-center gap-1 px-2 py-1 rounded-pill border bg-light small">
                <i class="bi bi-person-circle text-primary icon-sm"></i>
                <span class="d-none d-md-inline text-dark fw-semibold">{{ Auth::user()->name }}</span>
            </div>
            @endauth
        </div>
    </div>
</header>

