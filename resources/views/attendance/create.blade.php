@extends('layouts.app')
@section('title', 'Log Attendance')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg shadow-sm" style="background:#fef9c3;"><i class="bi bi-calendar-plus-fill icon-lg" style="color:#ca8a04;"></i></div>
        <div>
            <h2 class="fw-bold mb-0 text-dark">Log Daily Attendance</h2>
            <p class="text-muted small mb-0">Mark attendance status for all active students</p>
        </div>
    </div>
    <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-arrow-left me-1 icon-sm"></i>Back</a>
</div>

<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3">
        <div class="row align-items-center">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary mb-1 small">Attendance Date</label>
                <input type="date" id="attendanceDate" value="{{ $today }}" class="form-control" style="width: auto; display: inline-block;">
            </div>
            <div class="col-md-8 text-end">
                <button type="button" class="btn btn-sm btn-outline-success me-1" onclick="setAll('Present')"><i class="bi bi-check-all me-1"></i>Mark All Present</button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="setAll('Absent')"><i class="bi bi-x-lg me-1"></i>Mark All Absent</button>
            </div>
        </div>
    </div>
    <form action="{{ route('attendance.store') }}" method="POST" id="attendanceForm">
        @csrf
        <input type="hidden" name="date" id="dateHidden" value="{{ $today }}">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th class="ps-4">Student</th><th>Student ID</th><th>Course / Year</th><th>Status</th><th>Notes</th></tr></thead>
                    <tbody>
                        @foreach($students as $i => $student)
                        <input type="hidden" name="records[{{ $i }}][student_id]" value="{{ $student->id }}">
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $student->avatar_url }}" class="rounded-circle" width="36" height="36" style="object-fit:cover;">
                                    <div class="fw-bold small text-dark">{{ $student->name }}</div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border font-monospace small">{{ $student->student_number }}</span></td>
                            <td class="small text-muted">{{ $student->course }} — {{ $student->year_level }}</td>
                            <td>
                                <div class="btn-group btn-group-sm status-selector" data-index="{{ $i }}">
                                    @foreach($statuses as $status)
                                    <input type="radio" class="btn-check" name="records[{{ $i }}][status]" id="status_{{ $i }}_{{ $loop->index }}" value="{{ $status }}" {{ $status === 'Present' ? 'checked' : '' }} autocomplete="off">
                                    <label class="btn btn-outline-{{ $status === 'Present' ? 'success' : ($status === 'Absent' ? 'danger' : ($status === 'Late' ? 'warning' : 'secondary')) }} btn-sm" for="status_{{ $i }}_{{ $loop->index }}">{{ $status }}</label>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <input type="text" name="records[{{ $i }}][notes]" class="form-control form-control-sm" placeholder="Notes..." style="min-width: 120px;">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center">
            <span class="text-muted small">{{ $students->count() }} active students listed</span>
            <button type="submit" class="btn btn-primary px-5 shadow-sm fw-bold"><i class="bi bi-save-fill me-1"></i>Save Attendance</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('attendanceDate').addEventListener('change', function() {
    document.getElementById('dateHidden').value = this.value;
});

function setAll(status) {
    document.querySelectorAll('.status-selector').forEach(function(group) {
        const index = group.dataset.index;
        const radios = group.querySelectorAll('input[type="radio"]');
        radios.forEach(r => {
            if (r.value === status) r.checked = true;
        });
    });
}
</script>
@endpush
@endsection
