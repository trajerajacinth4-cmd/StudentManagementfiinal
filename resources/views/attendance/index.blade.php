@extends('layouts.app')
@section('title', 'Attendance - Student Management')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg shadow-sm" style="background:#fef9c3;"><i class="bi bi-calendar-check-fill icon-lg" style="color:#ca8a04;"></i></div>
        <div>
            <h2 class="fw-bold mb-0 text-dark">Attendance</h2>
            <p class="text-muted small mb-0">Daily attendance records for {{ now()->format('F d, Y') }}</p>
        </div>
    </div>
    <a href="{{ route('attendance.create') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus-circle-fill me-1 icon-sm"></i> Log Attendance</a>
</div>

<!-- Attendance Summary for Selected Date -->
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

<!-- Date & Filter Bar -->
<div class="card card-custom mb-4">
    <div class="card-body p-3">
        <form action="{{ route('attendance.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-secondary mb-1">Date</label>
                <input type="date" name="date" class="form-control" value="{{ $selectedDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-secondary mb-1">Student</label>
                <select name="student_id" class="form-select">
                    <option value="">All Students</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" {{ $selectedStudent == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel-fill me-1 icon-sm"></i>Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead><tr><th class="ps-4">Student</th><th>Date</th><th>Status</th><th>Notes</th></tr></thead>
                <tbody>
                    @forelse($attendances as $att)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $att->student->avatar_url }}" class="rounded-circle" width="32" height="32" style="object-fit:cover;">
                                <div class="fw-bold small text-dark">{{ $att->student->name }}</div>
                            </div>
                        </td>
                        <td class="small text-muted">{{ $att->date->format('F d, Y') }}</td>
                        <td>
                            <span class="badge badge-soft-{{ $att->status === 'Present' ? 'success' : ($att->status === 'Absent' ? 'danger' : 'warning') }} rounded-pill px-3">
                                {{ $att->status }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $att->notes ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5 text-muted">No attendance records for {{ $selectedDate }}. <a href="{{ route('attendance.create') }}">Log attendance now</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $attendances->links() }}</div>
@endsection
