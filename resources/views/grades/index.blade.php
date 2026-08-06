@extends('layouts.app')
@section('title', 'Grade Records')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg bg-indigo-subtle shadow-sm"><i class="bi bi-journal-richtext icon-lg text-indigo"></i></div>
        <div>
            <h2 class="fw-bold mb-0 text-dark">Grade Records</h2>
            <p class="text-muted small mb-0">View and manage academic grades per student</p>
        </div>
    </div>
    <a href="{{ route('grades.create') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus-circle-fill me-1 icon-sm"></i> Add Grade</a>
</div>

<div class="card card-custom mb-4">
    <div class="card-body p-3">
        <form action="{{ route('grades.index') }}" method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="student_id" class="form-select">
                    <option value="">All Students</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" {{ $selectedStudent == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
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
                <thead><tr><th class="ps-4">Student</th><th>Subject</th><th>Semester</th><th>Grade</th><th>Remarks</th><th class="pe-4 text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($grades as $grade)
                    <tr>
                        <td class="ps-4 fw-bold small text-dark">{{ $grade->student->name }}</td>
                        <td class="small"><span class="badge bg-indigo-subtle text-primary font-monospace">{{ $grade->subject->code }}</span> {{ $grade->subject->name }}</td>
                        <td class="small text-muted">{{ $grade->semester->label ?? 'N/A' }}</td>
                        <td><span class="badge bg-dark rounded-pill px-3 fw-bold">{{ $grade->grade ?? 'N/A' }}</span></td>
                        <td>
                            <span class="badge badge-soft-{{ $grade->remarks === 'Passed' ? 'success' : ($grade->remarks === 'Failed' ? 'danger' : 'warning') }} rounded-pill">
                                {{ $grade->remarks ?? 'Pending' }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('grades.edit', $grade->id) }}" class="btn btn-outline-warning"><i class="bi bi-pencil-square icon-sm"></i></a>
                                <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this grade?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash-fill icon-sm"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">No grade records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $grades->links() }}</div>
@endsection
