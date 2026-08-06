@extends('layouts.app')
@section('title', 'Enrollments')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg shadow-sm" style="background:#dcfce7;"><i class="bi bi-person-check-fill icon-lg" style="color:#16a34a;"></i></div>
        <div>
            <h2 class="fw-bold mb-0 text-dark">Enrollment Management</h2>
            <p class="text-muted small mb-0">Manage student enrollment per semester</p>
        </div>
    </div>
    <a href="{{ route('enrollments.create') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus-circle-fill me-1 icon-sm"></i> Enroll Student</a>
</div>

<div class="card card-custom mb-4">
    <div class="card-body p-3">
        <form action="{{ route('enrollments.index') }}" method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="semester_id" class="form-select">
                    <option value="">All Semesters</option>
                    @foreach($semesters as $sem)
                        <option value="{{ $sem->id }}" {{ $selectedSemester == $sem->id ? 'selected' : '' }}>{{ $sem->label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel-fill me-1 icon-sm"></i>Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead><tr><th class="ps-4">Student</th><th>Semester</th><th>Subjects</th><th>Status</th><th class="pe-4 text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $enrollment->student->avatar_url }}" class="rounded-circle" width="32" height="32" style="object-fit:cover;">
                                <div>
                                    <div class="fw-bold small text-dark">{{ $enrollment->student->name }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $enrollment->student->student_number }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="small text-muted">{{ $enrollment->semester->label ?? 'N/A' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $enrollment->subjects->count() }} subjects</span></td>
                        <td>
                            <span class="badge badge-soft-{{ $enrollment->status === 'Enrolled' ? 'success' : ($enrollment->status === 'Dropped' ? 'danger' : 'primary') }} rounded-pill">{{ $enrollment->status }}</span>
                        </td>
                        <td class="pe-4 text-end">
                            <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Drop this enrollment?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle icon-sm"></i> Drop</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted">No enrollment records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $enrollments->links() }}</div>
@endsection
