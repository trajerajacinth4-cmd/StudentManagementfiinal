@extends('layouts.app')

@section('title', 'Manage Courses - Student Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg bg-indigo-subtle shadow-sm">
            <i class="bi bi-book-fill icon-lg"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0 text-dark tracking-tight">Course Management</h2>
            <p class="text-muted small mb-0">Create, view, and manage academic courses available for student selection</p>
        </div>
    </div>
    <div>
        <a href="{{ route('courses.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center gap-1.5">
            <i class="bi bi-plus-circle-fill icon-sm"></i> Add New Course
        </a>
    </div>
</div>

<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header bg-white py-3 border-bottom border-light">
        <h5 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
            <i class="bi bi-list-stars text-indigo icon-md"></i> Managed Academic Courses
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" width="80px">#</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Description</th>
                        <th class="pe-4 text-end" width="150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td class="ps-4 text-muted fw-bold">{{ $course->id }}</td>
                            <td>
                                <span class="badge bg-indigo-subtle text-primary font-monospace px-2.5 py-1.5 rounded-pill">
                                    {{ $course->code }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">{{ $course->name }}</td>
                            <td class="text-secondary small">{{ $course->description ?? 'No description provided.' }}</td>
                            <td class="pe-4 text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-outline-warning" title="Edit Course">
                                        <i class="bi bi-pencil-square icon-sm"></i> Edit
                                    </a>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete Course">
                                            <i class="bi bi-trash-fill icon-sm"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <div class="icon-shape-lg bg-indigo-subtle rounded-circle mb-3 mx-auto">
                                        <i class="bi bi-book icon-xl text-primary"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">No courses added yet</h5>
                                    <p class="small text-muted mb-3">Add academic courses so they can be selected when creating students.</p>
                                    <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                                        <i class="bi bi-plus-lg me-1 icon-sm"></i>Add Course Now
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $courses->links() }}
</div>
@endsection
