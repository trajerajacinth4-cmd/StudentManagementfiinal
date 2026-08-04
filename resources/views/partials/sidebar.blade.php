<!-- Left Shrinkable Sidebar -->
<aside id="sidebar" class="sidebar shadow-sm">
    <!-- Sidebar Brand / Header -->
    <div class="sidebar-header d-flex align-items-center justify-content-between px-3 py-3 border-bottom border-secondary border-opacity-25">
        <a href="{{ url('/') }}" class="d-flex align-items-center gap-2.5 text-decoration-none text-white brand-wrapper">
            <div class="icon-shape-sm bg-indigo text-white shadow-sm flex-shrink-0" style="background: #4f46e5;">
                <i class="bi bi-mortarboard-fill icon-md"></i>
            </div>
            <span class="fs-5 fw-bold brand-text tracking-tight text-nowrap">StudentApp</span>
        </a>
        <button type="button" class="btn btn-link text-white-50 p-0 d-none d-lg-block sidebar-toggle-btn shadow-none" id="sidebarCollapseBtn" title="Toggle Sidebar (Ctrl+B)">
            <i class="bi bi-layout-sidebar-inset icon-md"></i>
        </button>
    </div>

    <!-- Sidebar Navigation Menu -->
    <div class="sidebar-body py-3">
        <div class="px-3 mb-2 sidebar-label text-uppercase text-white-50 fw-bold small tracking-wider">
            <span>Navigation</span>
        </div>
        <ul class="nav nav-pills flex-column px-2 gap-1">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->is('/') ? 'active bg-indigo text-white fw-semibold' : 'text-white-50 hover-bg-light' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Home">
                    <i class="bi bi-house-door-fill icon-md text-center flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Home</span>
                </a>
            </li>
            @auth
            <li class="nav-item">
                <a href="{{ route('students.index') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('students.index') ? 'active bg-indigo text-white fw-semibold' : 'text-white-50 hover-bg-light' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Student Directory">
                    <i class="bi bi-people-fill icon-md text-center flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Directory</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('students.create') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('students.create') ? 'active bg-indigo text-white fw-semibold' : 'text-white-50 hover-bg-light' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Add New Student">
                    <i class="bi bi-person-plus-fill icon-md text-center flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Add Student</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('courses.index') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('courses.*') ? 'active bg-indigo text-white fw-semibold' : 'text-white-50 hover-bg-light' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Manage Courses">
                    <i class="bi bi-book-fill icon-md text-center flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Courses</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('activity-logs.index') }}" class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('activity-logs.index') ? 'active bg-indigo text-white fw-semibold' : 'text-white-50 hover-bg-light' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="System Audit Logs">
                    <i class="bi bi-journal-text icon-md text-center flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Activity Logs</span>
                </a>
            </li>
            @endauth
        </ul>
    </div>

    <!-- Sidebar Footer / User Profile -->
    @auth
    <div class="sidebar-footer mt-auto p-3 border-top border-secondary border-opacity-25">
        <div class="d-flex align-items-center justify-content-between gap-2 user-profile-box">
            <div class="d-flex align-items-center gap-2.5 overflow-hidden">
                <div class="icon-shape-sm bg-info text-dark rounded-circle flex-shrink-0">
                    <i class="bi bi-person-circle icon-md"></i>
                </div>
                <div class="user-details overflow-hidden">
                    <div class="fw-bold text-white small text-truncate">{{ Auth::user()->name }}</div>
                    <div class="text-white-50 small text-truncate" style="font-size: 0.75rem;">Administrator</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link text-white-50 p-1 hover-text-danger shadow-none" title="Log Out">
                    <i class="bi bi-box-arrow-right icon-md"></i>
                </button>
            </form>
        </div>
    </div>
    @endauth
</aside>
