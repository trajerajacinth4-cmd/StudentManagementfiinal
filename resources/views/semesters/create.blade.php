@extends('layouts.app')
@section('title', 'Add Semester')
@section('content')
<div class="row justify-content-center"><div class="col-md-6">
<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #0891b2, #0e7490);">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-shape bg-white bg-opacity-20 text-white"><i class="bi bi-calendar-plus icon-lg"></i></div>
            <div><h4 class="mb-0 fw-bold">Add New Semester</h4><small class="opacity-75">Define a school year and semester</small></div>
        </div>
    </div>
    <div class="card-body p-4">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0 ps-3 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('semesters.store') }}" method="POST">@csrf
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Semester Name</label>
                <select name="name" class="form-select" required>
                    <option value="">Select Semester...</option>
                    @foreach($semesterNames as $sn)
                        <option value="{{ $sn }}" {{ old('name') === $sn ? 'selected' : '' }}>{{ $sn }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">School Year</label>
                <input type="text" name="school_year" class="form-control" value="{{ old('school_year', date('Y') . '-' . (date('Y') + 1)) }}" placeholder="e.g. 2026-2027" required>
            </div>
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold text-secondary" for="is_active">Set as Active Semester</label>
                </div>
                <div class="form-text small">Only one semester can be active at a time.</div>
            </div>
            <div class="d-flex justify-content-between pt-3 border-top">
                <a href="{{ route('semesters.index') }}" class="btn btn-outline-secondary px-4"><i class="bi bi-arrow-left me-1"></i>Cancel</a>
                <button type="submit" class="btn btn-primary px-4 shadow-sm"><i class="bi bi-check-circle-fill me-1"></i>Save Semester</button>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
