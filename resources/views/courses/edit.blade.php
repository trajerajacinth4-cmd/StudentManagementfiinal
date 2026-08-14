@extends('layouts.app')

@section('title', 'Edit Course - Student Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="card card-custom border-0 overflow-hidden">
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-shape bg-white bg-opacity-20 text-white shadow-sm">
                            <i class="bi bi-pencil-square icon-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">Edit Course Details</h4>
                            <small class="text-white opacity-75">Update course record for {{ $course->code }}</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-light border-0 opacity-90 opacity-100-hover px-3 py-1.5 rounded-pill shadow-none"
                            onclick="if(document.referrer && document.referrer !== window.location.href){ window.history.back(); } else { window.location.href='{{ route('courses.index') }}'; }"
                            title="Return to Recent Page">
                        <i class="bi bi-arrow-left me-1"></i> Return
                    </button>
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

                <form action="{{ route('courses.update', $course->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Course Code -->
                    <div class="mb-3">
                        <label for="code" class="form-label fw-semibold text-secondary">Course Code</label>
                        <div class="input-group">
                            <span class="input-group-text bg-indigo-subtle border-end-0"><i class="bi bi-tag text-indigo icon-md"></i></span>
                            <input type="text" name="code" id="code" class="form-control font-monospace" value="{{ old('code', $course->code) }}" required autofocus>
                        </div>
                    </div>

                    <!-- Course Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-secondary">Course Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-emerald-subtle border-end-0"><i class="bi bi-book text-emerald icon-md"></i></span>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $course->name) }}" required>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold text-secondary">Description (Optional)</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $course->description) }}</textarea>
                    </div>

                    <!-- Form Buttons -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('courses.index') }}"
                           onclick="if(document.referrer && document.referrer !== window.location.href){ window.history.back(); return false; }"
                           class="btn btn-outline-secondary px-4 d-flex align-items-center gap-1.5">
                            <i class="bi bi-arrow-left icon-sm"></i> Cancel / Return
                        </a>
                        <button type="submit" class="btn btn-warning px-4 shadow-sm fw-bold d-flex align-items-center gap-1.5">
                            <i class="bi bi-pencil-fill icon-sm"></i> Update Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
