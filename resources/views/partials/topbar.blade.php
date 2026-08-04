<!-- Topbar Header -->
<header class="topbar bg-white border-bottom sticky-top py-2 px-3 shadow-xs">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <!-- Sidebar Toggle Button (Mobile & Desktop) -->
            <button type="button" class="btn btn-light border-0 p-2 d-flex align-items-center justify-content-center rounded-3 shadow-none" id="topbarSidebarToggle" title="Toggle Sidebar Navigation">
                <i class="bi bi-list icon-lg text-dark"></i>
            </button>

            <!-- Breadcrumb / System Context -->
            <div class="d-none d-sm-block">
                <span class="badge bg-indigo-subtle text-primary fw-semibold px-2.5 py-1 rounded-pill small">
                    <i class="bi bi-shield-check me-1"></i> Student Management System
                </span>
            </div>
        </div>

        @auth
        <div class="d-flex align-items-center gap-3">
            <!-- User Welcome Badge -->
            <div class="d-flex align-items-center gap-2 bg-light px-3 py-1.5 rounded-pill border">
                <i class="bi bi-person-circle text-primary icon-md"></i>
                <span class="small">Welcome, <strong class="text-dark">{{ Auth::user()->name }}</strong></span>
            </div>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-pill d-flex align-items-center gap-1.5 shadow-sm">
                    <i class="bi bi-box-arrow-right icon-sm"></i> Log Out
                </button>
            </form>
        </div>
        @else
        <div>
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm">
                <i class="bi bi-box-arrow-in-right me-1"></i> Admin Login
            </a>
        </div>
        @endauth
    </div>
</header>
