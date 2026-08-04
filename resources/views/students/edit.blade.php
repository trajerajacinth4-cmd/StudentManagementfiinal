@extends('layouts.app')

@section('title', 'Edit Student - Student Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card card-custom border-0 overflow-hidden">
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-shape bg-white bg-opacity-20 text-white shadow-sm">
                        <i class="bi bi-pencil-square icon-lg"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">Edit Student Details</h4>
                        <small class="text-white opacity-75">Update record for {{ $student->name }}</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 mb-4" role="alert">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-triangle-fill icon-md me-2"></i>
                            <strong>Please check the form for errors:</strong>
                        </div>
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Current Avatar Preview & New File Upload -->
                    <div class="mb-4 d-flex align-items-center gap-3 bg-light p-3 rounded-4 border">
                        <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}" class="rounded-circle border border-2 border-white shadow-sm" width="64" height="64" style="object-fit: cover;">
                        <div class="flex-grow-1">
                            <label for="avatar" class="form-label fw-semibold text-secondary mb-1">Update Profile Picture</label>
                            <input type="file" name="avatar" id="avatar" class="form-control form-control-sm" accept="image/*">
                        </div>
                    </div>

                    <!-- Student Number / ID -->
                    <div class="mb-3">
                        <label for="student_number" class="form-label fw-semibold text-secondary">Student ID Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-cyan-subtle border-end-0"><i class="bi bi-card-heading text-cyan icon-md"></i></span>
                            <input type="text" name="student_number" id="student_number" class="form-control" value="{{ old('student_number', $student->student_number) }}" required>
                        </div>
                    </div>

                    <!-- Separated Name Fields (First, Middle, Last) -->
                    <div class="row">
                        <!-- First Name -->
                        <div class="col-md-4 mb-3">
                            <label for="first_name" class="form-label fw-semibold text-secondary">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-subtle border-end-0"><i class="bi bi-person text-indigo icon-md"></i></span>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $student->first_name) }}" required autofocus>
                            </div>
                        </div>

                        <!-- Middle Name -->
                        <div class="col-md-4 mb-3">
                            <label for="middle_name" class="form-label fw-semibold text-secondary">Middle Name <span class="text-muted fw-normal">(Optional)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-subtle border-end-0"><i class="bi bi-person text-indigo icon-md"></i></span>
                                <input type="text" name="middle_name" id="middle_name" class="form-control" value="{{ old('middle_name', $student->middle_name) }}">
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-4 mb-3">
                            <label for="last_name" class="form-label fw-semibold text-secondary">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-subtle border-end-0"><i class="bi bi-person text-indigo icon-md"></i></span>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $student->last_name) }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Email Address Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-emerald-subtle border-end-0"><i class="bi bi-envelope text-emerald icon-md"></i></span>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $student->email) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Course Select Dropdown (Managed Courses Only) -->
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="course" class="form-label fw-semibold text-secondary mb-0">Course / Major</label>
                                <a href="{{ route('courses.create') }}" class="small text-decoration-none fw-semibold text-primary" target="_blank">
                                    <i class="bi bi-plus-circle me-1"></i>Add Course
                                </a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-amber-subtle border-end-0"><i class="bi bi-book text-amber icon-md"></i></span>
                                <select name="course" id="course" class="form-select" required>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->code }}" {{ old('course', $student->course) === $c->code ? 'selected' : '' }}>
                                            {{ $c->code }} — {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Year Level Field -->
                        <div class="col-md-6 mb-3">
                            <label for="year_level" class="form-label fw-semibold text-secondary">Grade / Year Level</label>
                            <div class="input-group">
                                <span class="input-group-text bg-violet-subtle border-end-0"><i class="bi bi-mortarboard text-violet icon-md"></i></span>
                                <select name="year_level" id="year_level" class="form-select" required>
                                    @foreach($yearLevels as $year)
                                        <option value="{{ $year }}" {{ old('year_level', $student->year_level) === $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Status Field -->
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label fw-semibold text-secondary">Enrollment Status</label>
                            <div class="input-group">
                                <span class="input-group-text bg-emerald-subtle border-end-0"><i class="bi bi-info-circle text-emerald icon-md"></i></span>
                                <select name="status" id="status" class="form-select" required>
                                    @foreach($statuses as $st)
                                        <option value="{{ $st }}" {{ old('status', $student->status) === $st ? 'selected' : '' }}>
                                            {{ $st }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- GPA Field -->
                        <div class="col-md-4 mb-3">
                            <label for="gpa" class="form-label fw-semibold text-secondary">GPA</label>
                            <div class="input-group">
                                <span class="input-group-text bg-amber-subtle border-end-0"><i class="bi bi-star text-amber icon-md"></i></span>
                                <input type="number" step="0.01" min="0.00" max="5.00" name="gpa" id="gpa" class="form-control" value="{{ old('gpa', $student->gpa) }}">
                            </div>
                        </div>

                        <!-- Age Field -->
                        <div class="col-md-4 mb-4">
                            <label for="age" class="form-label fw-semibold text-secondary">Age</label>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-subtle border-end-0"><i class="bi bi-calendar-event text-indigo icon-md"></i></span>
                                <input type="number" name="age" id="age" class="form-control" value="{{ old('age', $student->age) }}" min="15" max="100" required>
                            </div>
                        </div>
                    </div>

                    <!-- Form Buttons -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary px-4 d-flex align-items-center gap-1.5">
                            <i class="bi bi-arrow-left icon-sm"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning px-4 shadow-sm fw-bold d-flex align-items-center gap-1.5">
                            <i class="bi bi-pencil-fill icon-sm"></i> Update Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
