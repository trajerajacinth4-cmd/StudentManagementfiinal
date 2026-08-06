@extends('layouts.app')

@section('title', '{{ $student->name }} - Student Profile')

@section('content')
<!-- Profile Header -->
<div class="card card-custom border-0 overflow-hidden mb-4" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
    <div class="card-body p-4 text-white">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}"
                 class="rounded-circle border border-3 border-white shadow"
                 width="90" height="90" style="object-fit:cover;">
            <div class="flex-grow-1">
                <h3 class="fw-bold mb-1">{{ $student->name }}</h3>
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <span class="badge bg-white text-dark font-monospace">{{ $student->student_number }}</span>
                    <span class="badge bg-white bg-opacity-25">{{ $student->course }}</span>
                    <span class="badge bg-white bg-opacity-25">{{ $student->year_level }}</span>
                    <span class="badge bg-{{ $student->status === 'Active' ? 'success' : 'secondary' }} text-white">{{ $student->status }}</span>
                </div>
                <div class="mt-2 small text-white opacity-75">
                    <i class="bi bi-envelope me-1"></i> {{ $student->email }}
                    &nbsp;&nbsp;
                    <i class="bi bi-calendar me-1"></i> Age {{ $student->age }}
                    @if($student->gpa)
                        &nbsp;&nbsp;
                        <i class="bi bi-star me-1"></i> GPA {{ number_format($student->gpa, 2) }}
                    @endif
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('students.profile-pdf', $student->id) }}" class="btn btn-sm btn-light rounded-pill shadow-sm d-flex align-items-center gap-1">
                    <i class="bi bi-file-earmark-pdf-fill text-danger icon-sm"></i> Download PDF
                </a>
                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-light rounded-pill shadow-sm d-flex align-items-center gap-1">
                    <i class="bi bi-pencil-square icon-sm text-warning"></i> Edit
                </a>
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-light rounded-pill shadow-sm d-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left icon-sm"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Summary Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card card-custom border-0 text-center py-3">
            <div class="fw-bold fs-2 text-success">{{ $presentCount }}</div>
            <div class="small text-muted"><i class="bi bi-check-circle-fill text-success me-1"></i>Present</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card card-custom border-0 text-center py-3">
            <div class="fw-bold fs-2 text-danger">{{ $absentCount }}</div>
            <div class="small text-muted"><i class="bi bi-x-circle-fill text-danger me-1"></i>Absent</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card card-custom border-0 text-center py-3">
            <div class="fw-bold fs-2 text-warning">{{ $lateCount }}</div>
            <div class="small text-muted"><i class="bi bi-clock-fill text-warning me-1"></i>Late</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Grades -->
    <div class="col-md-8">
        <div class="card card-custom border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-journal-richtext text-indigo icon-md"></i> Academic Grades
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Subject</th>
                                <th>Semester</th>
                                <th>Grade</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $grade)
                            <tr>
                                <td class="ps-4 fw-bold small">{{ $grade->subject->code }} — {{ $grade->subject->name }}</td>
                                <td class="small text-muted">{{ $grade->semester->label ?? 'N/A' }}</td>
                                <td><span class="badge bg-indigo-subtle text-primary fw-bold px-3">{{ $grade->grade ?? 'N/A' }}</span></td>
                                <td>
                                    <span class="badge badge-soft-{{ $grade->remarks === 'Passed' ? 'success' : ($grade->remarks === 'Failed' ? 'danger' : 'warning') }} rounded-pill">
                                        {{ $grade->remarks ?? 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No grade records yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollments & Recent Attendance -->
    <div class="col-md-4">
        <!-- Enrollments -->
        <div class="card card-custom border-0 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-check text-emerald icon-md"></i> Enrollments
                </h6>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($enrollments as $enrollment)
                <li class="list-group-item px-4 py-3">
                    <div class="fw-bold small">{{ $enrollment->semester->label ?? 'N/A' }}</div>
                    <span class="badge badge-soft-{{ $enrollment->status === 'Enrolled' ? 'success' : ($enrollment->status === 'Dropped' ? 'danger' : 'primary') }} rounded-pill small">
                        {{ $enrollment->status }}
                    </span>
                </li>
                @empty
                <li class="list-group-item text-muted text-center small py-3">No enrollment records.</li>
                @endforelse
            </ul>
        </div>

        <!-- Recent Attendance -->
        <div class="card card-custom border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-calendar3 text-amber icon-md"></i> Recent Attendance
                </h6>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($attendances->take(8) as $att)
                <li class="list-group-item px-4 py-2 d-flex justify-content-between align-items-center">
                    <span class="small text-muted">{{ $att->date->format('M d, Y') }}</span>
                    <span class="badge badge-soft-{{ $att->status === 'Present' ? 'success' : ($att->status === 'Absent' ? 'danger' : 'warning') }} rounded-pill">
                        {{ $att->status }}
                    </span>
                </li>
                @empty
                <li class="list-group-item text-muted text-center small py-3">No attendance logged yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
