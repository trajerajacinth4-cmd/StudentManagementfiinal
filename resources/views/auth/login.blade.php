<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-login {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            background: #ffffff;
        }
        .card-login .card-header {
            background: transparent;
            border-bottom: none;
            padding-top: 2rem;
            padding-bottom: 1rem;
        }
        .btn-custom {
            background: #4f46e5;
            color: #ffffff;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background: #4338ca;
            color: #ffffff;
            transform: translateY(-1px);
        }
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.25);
            border-color: #4f46e5;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card card-login p-4">
                <div class="card-header text-center">
                    <h3 class="fw-bold text-dark mb-1">Welcome Back</h3>
                    <p class="text-muted small">Log in to manage your students</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label font-weight-semibold text-secondary">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-secondary">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label for="remember" class="form-check-label text-secondary small">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-custom w-100 mb-3">Log In</button>
                    </form>

                    <div class="text-center mt-3">
                        <span class="text-muted small">Don't have an account?</span>
                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary small">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
