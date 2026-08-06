@extends('layouts.app')
@section('title', 'Add Subject')
@section('content')
<div class="row justify-content-center"><div class="col-md-6">
<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-shape bg-white bg-opacity-20 text-white shadow-sm"><i class="bi bi-journal-plus icon-lg"></i></div>
            <div><h4 class="mb-0 fw-bold">Add New Subject</h4><small class="text-white opacity-75">Create an academic subject</small></div>
        </div>
    </div>
    <div class="card-body p-4">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0 ps-3 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('subjects.store') }}" method="POST">@csrf
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Subject Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="e.g. CS101" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Subject Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Introduction to Computing" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Units</label>
                <input type="number" name="units" step="0.5" min="0.5" max="9" class="form-control" value="{{ old('units', 3) }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Description (Optional)</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Brief course description...">{{ old('description') }}</textarea>
            </div>
            <div class="d-flex justify-content-between pt-3 border-top">
                <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary px-4"><i class="bi bi-arrow-left icon-sm me-1"></i>Cancel</a>
                <button type="submit" class="btn btn-primary px-4 shadow-sm"><i class="bi bi-check-circle-fill icon-sm me-1"></i>Save Subject</button>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
