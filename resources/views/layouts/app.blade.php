<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Management System')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --font-main: 'Plus Jakarta Sans', sans-serif;
            --primary-indigo: #4f46e5;
            --primary-indigo-hover: #4338ca;
            --slate-dark: #0f172a;
            --slate-bg: #f8fafc;
            
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 76px;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--slate-bg);
            color: #1e293b;
            overflow-x: hidden;
        }

        #app-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0f172a 0%, #1e1b4b 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
        }

        /* Collapsed Sidebar State */
        #app-layout.sidebar-collapsed #sidebar {
            width: var(--sidebar-collapsed-width);
        }

        #app-layout.sidebar-collapsed #sidebar .nav-text,
        #app-layout.sidebar-collapsed #sidebar .brand-text,
        #app-layout.sidebar-collapsed #sidebar .sidebar-label,
        #app-layout.sidebar-collapsed #sidebar .user-details {
            display: none !important;
        }

        #app-layout.sidebar-collapsed #sidebar .nav-link {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        #app-layout.sidebar-collapsed #sidebar .user-profile-box {
            justify-content: center !important;
        }

        /* Main Content Wrapper */
        #content-wrapper {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #app-layout.sidebar-collapsed #content-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Responsive Mobile Drawer (< 992px) */
        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
                width: var(--sidebar-width) !important;
            }
            #content-wrapper {
                margin-left: 0 !important;
            }
            #app-layout.mobile-sidebar-show #sidebar {
                margin-left: 0;
                box-shadow: 0 1rem 3rem rgba(0,0,0,0.4) !important;
            }
            #sidebar-backdrop {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.6);
                z-index: 1030;
                backdrop-filter: blur(2px);
            }
            #app-layout.mobile-sidebar-show #sidebar-backdrop {
                display: block;
            }
        }

        /* Utility Styles & Components */
        .icon-sm { font-size: 0.875rem !important; }
        .icon-md { font-size: 1.1rem !important; }
        .icon-lg { font-size: 1.4rem !important; }
        .icon-xl { font-size: 2rem !important; }

        .icon-shape-sm {
            width: 32px;
            height: 32px;
            border-radius: 0.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .icon-shape-lg {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .bg-indigo { background-color: var(--primary-indigo) !important; }
        .bg-indigo-subtle { background-color: #e0e7ff !important; color: #4338ca !important; }
        .bg-emerald-subtle { background-color: #d1fae5 !important; color: #047857 !important; }
        .bg-amber-subtle { background-color: #fef3c7 !important; color: #b45309 !important; }
        .bg-rose-subtle { background-color: #ffe4e6 !important; color: #be123c !important; }
        .bg-violet-subtle { background-color: #ede9fe !important; color: #6d28d9 !important; }
        .bg-cyan-subtle { background-color: #cffaff !important; color: #0e7490 !important; }

        .badge-soft-primary { background-color: #e0e7ff; color: #3730a3; font-weight: 600; }
        .badge-soft-success { background-color: #d1fae5; color: #065f46; font-weight: 600; }
        .badge-soft-warning { background-color: #fef3c7; color: #92400e; font-weight: 600; }
        .badge-soft-danger  { background-color: #ffe4e6; color: #9f1239; font-weight: 600; }
        .badge-soft-violet  { background-color: #ede9fe; color: #5b21b6; font-weight: 600; }
        .badge-soft-cyan    { background-color: #cffaff; color: #155e75; font-weight: 600; }

        .hover-bg-light:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        .card-custom {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 1rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }
    </style>
</head>
<body class="h-100">

    <div id="app-layout">
        <!-- Sidebar Navigation -->
        @include('partials.sidebar')

        <!-- Mobile Backdrop Overlay -->
        <div id="sidebar-backdrop"></div>

        <!-- Main Content Area -->
        <div id="content-wrapper">
            <!-- Topbar Header -->
            @include('partials.topbar')

            <!-- Main Body Container -->
            <main class="container-fluid px-3 px-md-4 py-4 flex-shrink-0">
                <!-- Flash Alerts -->
                @include('partials.alerts')

                @yield('content')
            </main>

            <!-- Footer -->
            @include('partials.footer')
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const appLayout = document.getElementById('app-layout');
            const topbarToggleBtn = document.getElementById('topbarSidebarToggle');
            const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
            const mobileBackdrop = document.getElementById('sidebar-backdrop');
            const STORAGE_KEY = 'student_app_sidebar_collapsed';

            // Check LocalStorage for saved collapsed state
            if (localStorage.getItem(STORAGE_KEY) === 'true') {
                appLayout.classList.add('sidebar-collapsed');
            }

            // Function to toggle Sidebar Collapsed / Expanded state
            function toggleSidebar() {
                if (window.innerWidth < 992) {
                    appLayout.classList.toggle('mobile-sidebar-show');
                } else {
                    appLayout.classList.toggle('sidebar-collapsed');
                    const isCollapsed = appLayout.classList.contains('sidebar-collapsed');
                    localStorage.setItem(STORAGE_KEY, isCollapsed);
                }
            }

            topbarToggleBtn?.addEventListener('click', toggleSidebar);
            sidebarCollapseBtn?.addEventListener('click', toggleSidebar);
            mobileBackdrop?.addEventListener('click', function () {
                appLayout.classList.remove('mobile-sidebar-show');
            });

            // Initialize Bootstrap Tooltips for Collapsed State
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover'
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
