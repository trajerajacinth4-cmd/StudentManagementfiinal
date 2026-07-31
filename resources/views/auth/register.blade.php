<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Management</title>
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
        .card-register {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            background: #ffffff;
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
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card card-register p-4">
                <div class="card-header bg-white border-0 text-center pt-3">
                    <h3 class="fw-bold text-dark mb-1">Create Account</h3>
                    <p class="text-muted small">Register to get started</p>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label text-secondary">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="John Doe" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="john@example.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-secondary">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
                        </div>

                        <button type="submit" class="btn btn-custom w-100 mb-3">Register</button>
                    </form>

                    <div class="text-center mt-3">
                        <span class="text-muted small">Already have an account?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary small">Log In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
