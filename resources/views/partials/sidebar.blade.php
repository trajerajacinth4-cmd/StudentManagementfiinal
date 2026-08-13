<!-- Left Shrinkable Sidebar -->
<aside id="sidebar" class="sidebar shadow-sm">
    <!-- Sidebar Brand / Header -->
    <div class="sidebar-header d-flex align-items-center justify-content-between px-3 py-3 border-bottom border-secondary border-opacity-25">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none text-white brand-wrapper">
            <div class="icon-shape-sm bg-indigo text-white shadow-sm flex-shrink-0" style="background: #4f46e5;">
                <i class="bi bi-mortarboard-fill icon-md"></i>
            </div>
            <span class="fs-5 fw-bold brand-text tracking-tight text-nowrap">StudentApp</span>
        </a>
        <button type="button"
                class="btn btn-link text-white-50 p-0 d-none d-lg-block sidebar-toggle-btn shadow-none"
                id="sidebarCollapseBtn"
                title="Collapse Sidebar">
            <i class="bi bi-layout-sidebar-inset icon-md"></i>
        </button>
    </div>

    <!-- Sidebar Navigation Menu -->
    <div class="sidebar-body py-3 flex-grow-1 overflow-auto">

        <!-- Main -->
        <div class="px-3 mb-1 sidebar-label text-uppercase text-white-50 fw-bold small tracking-wider">
            <span>Main</span>
        </div>
        <ul class="nav nav-pills flex-column px-2 gap-1 mb-3">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('dashboard') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                    <i class="bi bi-speedometer2 icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Dashboard</span>
                </a>
            </li>
        </ul>

        <!-- Students -->
        <div class="px-3 mb-1 sidebar-label text-uppercase text-white-50 fw-bold small tracking-wider">
            <span>Students</span>
        </div>
        <ul class="nav nav-pills flex-column px-2 gap-1 mb-3">
            <li class="nav-item">
                <a href="{{ route('students.index') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('students.index') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Student Directory">
                    <i class="bi bi-people-fill icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Directory</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('students.create') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('students.create') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Add New Student">
                    <i class="bi bi-person-plus-fill icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Add Student</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('students.honor-roll') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('students.honor-roll') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Honor Roll">
                    <i class="bi bi-trophy-fill icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Honor Roll</span>
                </a>
            </li>
        </ul>

        <!-- Academic -->
        <div class="px-3 mb-1 sidebar-label text-uppercase text-white-50 fw-bold small tracking-wider">
            <span>Academic</span>
        </div>
        <ul class="nav nav-pills flex-column px-2 gap-1 mb-3">
            <li class="nav-item">
                <a href="{{ route('courses.index') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('courses.*') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Courses">
                    <i class="bi bi-book-fill icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Courses</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('subjects.index') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('subjects.*') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Subjects">
                    <i class="bi bi-journal-bookmark-fill icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Subjects</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('semesters.index') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('semesters.*') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Semesters">
                    <i class="bi bi-calendar3 icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Semesters</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('enrollments.index') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('enrollments.*') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Enrollments">
                    <i class="bi bi-person-check-fill icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Enrollments</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('grades.index') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('grades.*') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Grades">
                    <i class="bi bi-journal-richtext icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Grades</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('attendance.index') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('attendance.*') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Attendance">
                    <i class="bi bi-calendar-check-fill icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Attendance</span>
                </a>
            </li>
        </ul>

        <!-- System -->
        <div class="px-3 mb-1 sidebar-label text-uppercase text-white-50 fw-bold small tracking-wider">
            <span>System</span>
        </div>
        <ul class="nav nav-pills flex-column px-2 gap-1">
            <li class="nav-item">
                <a href="{{ route('activity-logs.index') }}"
                   class="nav-link d-flex align-items-center gap-3 px-3 py-2 rounded-3 {{ request()->routeIs('activity-logs.index') ? 'active fw-semibold' : 'text-white-50 hover-bg-light' }}"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="Activity Logs">
                    <i class="bi bi-journal-text icon-md flex-shrink-0"></i>
                    <span class="nav-text text-nowrap">Activity Logs</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Sidebar Footer / User Profile + Logout -->
    <div class="sidebar-footer p-3 border-top border-secondary border-opacity-25">
        <div class="d-flex align-items-center justify-content-between gap-2 user-profile-box">
            <div class="d-flex align-items-center gap-2 overflow-hidden">
                <!-- Online indicator dot -->
                <div class="position-relative flex-shrink-0">
                    <div class="icon-shape-sm bg-info text-dark rounded-circle">
                        <i class="bi bi-person-circle icon-md"></i>
                    </div>
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-dark"
                          style="width:9px;height:9px;"></span>
                </div>
                <div class="user-details overflow-hidden">
                    <div class="fw-bold text-white small text-truncate">{{ Auth::user()->name }}</div>
                    <div class="text-white-50 text-truncate" style="font-size:0.72rem;">Administrator</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit"
                        class="btn btn-link text-white-50 p-1 shadow-none"
                        title="Log Out"
                        style="transition: color .15s;"
                        onmouseenter="this.style.color='#f87171'"
                        onmouseleave="this.style.color=''">
                    <i class="bi bi-box-arrow-right icon-md"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

