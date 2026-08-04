<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Student Management System</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .hero-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            color: #ffffff;
            padding: 5.5rem 0 6.5rem 0;
        }
        .icon-shape-feature {
            width: 54px;
            height: 54px;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            font-size: 1.5rem;
        }
        .card-feature {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }
        .card-feature:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #c7d2fe;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background: #0f172a;">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
                <div class="p-2 bg-indigo rounded-3 text-white d-inline-flex align-items-center justify-content-center" style="background: #4f46e5; width: 36px; height: 36px;">
                    <i class="bi bi-mortarboard-fill fs-5"></i>
                </div>
                <span class="fs-4 tracking-tight">StudentApp</span>
            </a>
            
            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ route('students.index') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light px-4 py-2 rounded-pill d-flex align-items-center gap-2">
                        <i class="bi bi-box-arrow-in-right"></i> Admin Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center text-lg-start">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-7">
                    <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-20 px-3 py-2 rounded-pill fw-semibold mb-3 d-inline-flex align-items-center gap-1.5">
                        <i class="bi bi-stars text-warning"></i> Powerful & Streamlined Administration
                    </span>
                    <h1 class="display-4 fw-bold text-white mb-3 tracking-tight">
                        Next-Gen Student Management Portal
                    </h1>
                    <p class="lead text-light opacity-75 mb-4">
                        Organize, filter, export, and manage student profiles, grade levels, enrollment statuses, and activity audit logs with exceptional design.
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        @auth
                            <a href="{{ route('students.index') }}" class="btn btn-primary btn-lg px-4 py-3 rounded-4 shadow-lg d-flex align-items-center gap-2" style="background: #4f46e5; border-color: #4f46e5;">
                                <i class="bi bi-people-fill"></i> Manage Students
                            </a>
                            <a href="{{ route('activity-logs.index') }}" class="btn btn-outline-light btn-lg px-4 py-3 rounded-4 d-flex align-items-center gap-2">
                                <i class="bi bi-journal-text"></i> Audit Logs
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-4 shadow-lg d-flex align-items-center gap-2" style="background: #4f46e5; border-color: #4f46e5;">
                                <i class="bi bi-shield-lock"></i> Sign In as Admin
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <div class="p-4 bg-white rounded-4 shadow-lg text-dark border border-white">
                        <div class="d-inline-flex p-3 rounded-circle mb-3 text-primary" style="background: #e0e7ff;">
                            <i class="bi bi-mortarboard display-2 text-indigo" style="color: #4f46e5;"></i>
                        </div>
                        <h4 class="fw-bold mb-1">StudentApp Portal</h4>
                        <p class="text-muted small mb-4">Single Administrative Portal for Academic Operations</p>
                        <div class="row g-3 text-center">
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3">
                                    <h3 class="fw-bold text-primary mb-0" style="color: #4f46e5 !important;">100%</h3>
                                    <small class="text-muted fw-semibold">Responsive UI</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3">
                                    <h3 class="fw-bold text-success mb-0" style="color: #10b981 !important;">PDF/CSV</h3>
                                    <small class="text-muted fw-semibold">Instant Exports</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="py-5 my-4">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-indigo-subtle text-primary rounded-pill px-3 py-1.5 fw-bold mb-2" style="background: #e0e7ff; color: #4338ca;">Features Showcase</span>
                <h2 class="fw-bold text-dark tracking-tight">Everything You Need to Manage Students</h2>
                <p class="text-muted">Engineered with speed, searchability, and security in mind.</p>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-feature h-100 p-4">
                        <div class="icon-shape-feature text-primary" style="background: #e0e7ff; color: #4338ca;">
                            <i class="bi bi-search"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Live Search & Multi-Filters</h5>
                        <p class="text-muted small mb-0">Filter students instantly by Grade Year Level, Status, Course, or search by student ID and name.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-feature h-100 p-4">
                        <div class="icon-shape-feature text-success" style="background: #d1fae5; color: #047857;">
                            <i class="bi bi-file-earmark-spreadsheet"></i>
                        </div>
                        <h5 class="fw-bold mb-2">CSV & PDF Reports</h5>
                        <p class="text-muted small mb-0">Export student directories to formatted PDF reports or stream full CSV files for spreadsheet editing.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-feature h-100 p-4">
                        <div class="icon-shape-feature text-warning" style="background: #fef3c7; color: #b45309;">
                            <i class="bi bi-file-arrow-up"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Bulk CSV Import</h5>
                        <p class="text-muted small mb-0">Import hundreds of student records at once using automated CSV header parsing and validation.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-feature h-100 p-4">
                        <div class="icon-shape-feature text-info" style="background: #cffaff; color: #0e7490;">
                            <i class="bi bi-person-bounding-box"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Avatars & Student IDs</h5>
                        <p class="text-muted small mb-0">Upload student profile photos, track custom Student ID numbers, and monitor individual GPA scores.</p>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-feature h-100 p-4">
                        <div class="icon-shape-feature" style="background: #ede9fe; color: #6d28d9;">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Bulk Promotion & Actions</h5>
                        <p class="text-muted small mb-0">Perform multi-select bulk deletions or promote student grade levels at the end of an academic term.</p>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card card-feature h-100 p-4">
                        <div class="icon-shape-feature text-danger" style="background: #ffe4e6; color: #be123c;">
                            <i class="bi bi-journal-check"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Real-time Audit Logs</h5>
                        <p class="text-muted small mb-0">Track every administrative action with recorded timestamps, IP addresses, and mutation details.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer mt-auto py-4 bg-white border-top text-center text-muted small">
        <div class="container">
            <span>&copy; {{ date('Y') }} <strong>StudentApp</strong> — Student Management System. All rights reserved.</span>
        </div>
    </footer>

    <!-- Bootstrap 5.3.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
