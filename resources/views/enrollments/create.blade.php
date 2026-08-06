@extends('layouts.app')
@section('title', 'Enroll Student')
@section('content')
<div class="row justify-content-center"><div class="col-md-7">
<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #16a34a, #15803d);">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-shape bg-white bg-opacity-20 text-white"><i class="bi bi-person-check-fill icon-lg"></i></div>
            <div><h4 class="mb-0 fw-bold">Enroll Student</h4><small class="opacity-75">Register a student for a semester</small></div>
        </div>
    </div>
    <div class="card-body p-4">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0 ps-3 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('enrollments.store') }}" method="POST">@csrf

            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Student</label>
                <select name="student_id" class="form-select" required>
                    <option value="">Select Student...</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->student_number }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Semester</label>
                <select name="semester_id" class="form-select" required>
                    <option value="">Select Semester...</option>
                    @foreach($semesters as $sem)
                        <option value="{{ $sem->id }}" {{ (old('semester_id') ?? $activeSemester?->id) == $sem->id ? 'selected' : '' }}>
                            {{ $sem->label }} {{ $sem->is_active ? '(Active)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Enrollment Status</label>
                <select name="status" class="form-select" required>
                    @foreach(\App\Models\Enrollment::$statuses as $st)
                        <option value="{{ $st }}" {{ old('status', 'Enrolled') === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Subjects Enrolled</label>
                <div class="border rounded-3 p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                    @foreach($subjects as $subject)
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" id="subj_{{ $subject->id }}"
                               {{ in_array($subject->id, old('subject_ids', [])) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="subj_{{ $subject->id }}">
                            <span class="badge bg-indigo-subtle text-primary font-monospace me-1">{{ $subject->code }}</span>
                            {{ $subject->name }} <span class="text-muted">({{ $subject->units }} units)</span>
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="form-text small">Select all subjects this student is enrolling in.</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Notes (Optional)</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="Any notes about this enrollment...">{{ old('notes') }}</textarea>
            </div>

            <div class="d-flex justify-content-between pt-3 border-top">
                <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary px-4"><i class="bi bi-arrow-left me-1"></i>Cancel</a>
                <button type="submit" class="btn btn-success px-4 shadow-sm"><i class="bi bi-check-circle-fill me-1"></i>Enroll Student</button>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
