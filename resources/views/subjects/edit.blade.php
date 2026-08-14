@extends('layouts.app')
@section('title', 'Edit Subject')
@section('content')
<div class="row justify-content-center"><div class="col-md-6">
<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-shape bg-white bg-opacity-20 text-white shadow-sm"><i class="bi bi-pencil-square icon-lg"></i></div>
                <div><h4 class="mb-0 fw-bold">Edit Subject</h4><small class="text-white opacity-75">{{ $subject->code }}</small></div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-light border-0 opacity-90 opacity-100-hover px-3 py-1.5 rounded-pill shadow-none"
                    onclick="if(document.referrer && document.referrer !== window.location.href){ window.history.back(); } else { window.location.href='{{ route('subjects.index') }}'; }"
                    title="Return to Recent Page">
                <i class="bi bi-arrow-left me-1"></i> Return
            </button>
        </div>
    </div>
    <div class="card-body p-4">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0 ps-3 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">@csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Subject Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $subject->code) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Subject Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $subject->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Units</label>
                <input type="number" name="units" step="0.5" min="0.5" max="9" class="form-control" value="{{ old('units', $subject->units) }}" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $subject->description) }}</textarea>
            </div>
            <div class="d-flex justify-content-between pt-3 border-top">
                <a href="{{ route('subjects.index') }}" onclick="if(document.referrer && document.referrer !== window.location.href){ window.history.back(); return false; }" class="btn btn-outline-secondary px-4"><i class="bi bi-arrow-left icon-sm me-1"></i>Cancel / Return</a>
                <button type="submit" class="btn btn-warning px-4 shadow-sm fw-bold"><i class="bi bi-pencil-fill icon-sm me-1"></i>Update Subject</button>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
