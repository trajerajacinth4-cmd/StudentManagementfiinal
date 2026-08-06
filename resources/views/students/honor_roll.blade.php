@extends('layouts.app')

@section('title', 'Honor Roll - Student Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg shadow-sm" style="background: #fef9c3;">
            <i class="bi bi-trophy-fill icon-lg" style="color: #ca8a04;"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0 text-dark">Honor Roll</h2>
            <p class="text-muted small mb-0">Students achieving GPA ≤ {{ $gpaThreshold }} (lower is better in Philippine grading)</p>
        </div>
    </div>
    <a href="{{ route('students.honor-roll', ['gpa' => $gpaThreshold]) }}" class="btn btn-outline-warning shadow-sm d-flex align-items-center gap-1.5">
        <i class="bi bi-download icon-sm"></i> Export List
    </a>
</div>

<!-- Filter Bar -->
<div class="card card-custom mb-4">
    <div class="card-body p-3">
        <form action="{{ route('students.honor-roll') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-secondary mb-1">GPA Threshold (≤)</label>
                <input type="number" name="gpa" step="0.25" min="1.00" max="3.00" value="{{ $gpaThreshold }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-secondary mb-1">Year Level</label>
                <select name="year_level" class="form-select">
                    <option value="">All Year Levels</option>
                    @foreach($yearLevels as $yr)
                        <option value="{{ $yr }}" {{ $yearLevel === $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 shadow-sm">
                    <i class="bi bi-funnel-fill icon-sm me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
            <i class="bi bi-award text-amber icon-md"></i> Honor Students
        </h6>
        <span class="badge bg-dark rounded-pill px-3">{{ $students->count() }} students</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" width="50px">Rank</th>
                        <th width="60px">Photo</th>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>GPA</th>
                        <th class="pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $rank => $student)
                    <tr>
                        <td class="ps-4">
                            @if($rank === 0)
                                <span class="fs-5">🥇</span>
                            @elseif($rank === 1)
                                <span class="fs-5">🥈</span>
                            @elseif($rank === 2)
                                <span class="fs-5">🥉</span>
                            @else
                                <span class="fw-bold text-muted">{{ $rank + 1 }}</span>
                            @endif
                        </td>
                        <td>
                            <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}" class="rounded-circle border border-2 border-white shadow-sm" width="40" height="40" style="object-fit:cover;">
                        </td>
                        <td class="fw-bold text-dark">{{ $student->name }}</td>
                        <td><span class="badge bg-light text-dark border font-monospace">{{ $student->student_number }}</span></td>
                        <td>{{ $student->course }}</td>
                        <td>{{ $student->year_level }}</td>
                        <td>
                            <span class="badge bg-success rounded-pill px-3 fw-bold">{{ number_format($student->gpa, 2) }}</span>
                        </td>
                        <td class="pe-4">
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-eye icon-sm"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <div class="py-4">
                                <i class="bi bi-trophy icon-xl text-muted"></i>
                                <h5 class="fw-bold mt-3">No students qualify for the honor roll</h5>
                                <p class="small">Try increasing the GPA threshold or adding GPA data to students.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
