@extends('layouts.app')
@section('title', 'Add Grade')
@section('content')
<div class="row justify-content-center"><div class="col-md-6">
<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-shape bg-white bg-opacity-20 text-white"><i class="bi bi-journal-plus icon-lg"></i></div>
                <div><h4 class="mb-0 fw-bold">Add Grade</h4><small class="opacity-75">Enter student grade per subject</small></div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-light border-0 opacity-90 opacity-100-hover px-3 py-1.5 rounded-pill shadow-none"
                    onclick="if(document.referrer && document.referrer !== window.location.href){ window.history.back(); } else { window.location.href='{{ route('grades.index') }}'; }"
                    title="Return to Recent Page">
                <i class="bi bi-arrow-left me-1"></i> Return
            </button>
        </div>
    </div>
    <div class="card-body p-4">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0 ps-3 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('grades.store') }}" method="POST">@csrf
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
                <label class="form-label fw-semibold text-secondary">Subject</label>
                <select name="subject_id" class="form-select" required>
                    <option value="">Select Subject...</option>
                    @foreach($subjects as $sub)
                        <option value="{{ $sub->id }}" {{ old('subject_id') == $sub->id ? 'selected' : '' }}>{{ $sub->code }} — {{ $sub->name }}</option>
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
                <label class="form-label fw-semibold text-secondary">Grade <span class="text-muted fw-normal">(1.00 = Highest)</span></label>
                <input type="number" name="grade" step="0.25" min="1.00" max="5.00" class="form-control" value="{{ old('grade') }}" placeholder="e.g. 1.25">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Remarks</label>
                <select name="remarks" class="form-select">
                    <option value="">Select Remarks...</option>
                    @foreach($remarks as $r)
                        <option value="{{ $r }}" {{ old('remarks') === $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex justify-content-between pt-3 border-top">
                <a href="{{ route('grades.index') }}" onclick="if(document.referrer && document.referrer !== window.location.href){ window.history.back(); return false; }" class="btn btn-outline-secondary px-4"><i class="bi bi-arrow-left me-1"></i>Cancel / Return</a>
                <button type="submit" class="btn btn-primary px-4 shadow-sm"><i class="bi bi-check-circle-fill me-1"></i>Save Grade</button>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
