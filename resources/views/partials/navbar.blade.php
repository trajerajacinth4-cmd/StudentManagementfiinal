<!-- Responsive Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%) !important;">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
            <div class="icon-shape-sm bg-indigo-subtle">
                <i class="bi bi-mortarboard-fill icon-md"></i>
            </div>
            <span class="fs-5 tracking-tight">StudentApp</span>
        </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3 gap-1">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-3 {{ request()->is('/') ? 'active bg-white bg-opacity-10 fw-semibold text-white' : 'text-white opacity-75' }}" href="{{ url('/') }}">
                        <i class="bi bi-house-door-fill me-1.5 icon-sm"></i> Home
                    </a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-3 {{ request()->routeIs('students.index') ? 'active bg-white bg-opacity-10 fw-semibold text-white' : 'text-white opacity-75' }}" href="{{ route('students.index') }}">
                        <i class="bi bi-people-fill me-1.5 icon-sm"></i> Directory
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-3 {{ request()->routeIs('students.create') ? 'active bg-white bg-opacity-10 fw-semibold text-white' : 'text-white opacity-75' }}" href="{{ route('students.create') }}">
                        <i class="bi bi-person-plus-fill me-1.5 icon-sm"></i> Add Student
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-3 {{ request()->routeIs('activity-logs.index') ? 'active bg-white bg-opacity-10 fw-semibold text-white' : 'text-white opacity-75' }}" href="{{ route('activity-logs.index') }}">
                        <i class="bi bi-journal-text me-1.5 icon-sm"></i> Activity Logs
                    </a>
                </li>
                @endauth
            </ul>

            @auth
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-1.5 rounded-pill border border-white border-opacity-10 text-white">
                    <i class="bi bi-person-circle text-info icon-md"></i>
                    <span class="small">Welcome, <strong class="text-white">{{ Auth::user()->name }}</strong></span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm px-3 rounded-pill d-flex align-items-center gap-1">
                        <i class="bi bi-box-arrow-right icon-sm"></i> Log Out
                    </button>
                </form>
            </div>
            @else
            <div class="d-flex align-items-center">
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-4 rounded-pill d-flex align-items-center gap-1">
                    <i class="bi bi-box-arrow-in-right icon-sm"></i> Admin Login
                </a>
            </div>
            @endauth
        </div>
    </div>
</nav>
