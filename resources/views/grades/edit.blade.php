@extends('layouts.app')
@section('title', 'Edit Grade')
@section('content')
<div class="row justify-content-center"><div class="col-md-6">
<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-shape bg-white bg-opacity-20 text-white"><i class="bi bi-pencil-square icon-lg"></i></div>
            <div>
                <h4 class="mb-0 fw-bold">Edit Grade</h4>
                <small class="opacity-75">{{ $grade->student->name }} — {{ $grade->subject->code }}</small>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0 ps-3 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif

        <div class="alert alert-light border rounded-3 mb-4 small">
            <div class="row">
                <div class="col-4"><strong class="text-secondary d-block">Student</strong>{{ $grade->student->name }}</div>
                <div class="col-4"><strong class="text-secondary d-block">Subject</strong>{{ $grade->subject->code }} — {{ $grade->subject->name }}</div>
                <div class="col-4"><strong class="text-secondary d-block">Semester</strong>{{ $grade->semester->label ?? 'N/A' }}</div>
            </div>
        </div>

        <form action="{{ route('grades.update', $grade->id) }}" method="POST">@csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Grade <span class="text-muted fw-normal">(1.00 = Highest)</span></label>
                <input type="number" name="grade" step="0.25" min="1.00" max="5.00" class="form-control" value="{{ old('grade', $grade->grade) }}" placeholder="e.g. 1.25">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Remarks</label>
                <select name="remarks" class="form-select">
                    <option value="">Select Remarks...</option>
                    @foreach($remarks as $r)
                        <option value="{{ $r }}" {{ old('remarks', $grade->remarks) === $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex justify-content-between pt-3 border-top">
                <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary px-4"><i class="bi bi-arrow-left me-1"></i>Cancel</a>
                <button type="submit" class="btn btn-warning px-4 shadow-sm fw-bold"><i class="bi bi-pencil-fill me-1"></i>Update Grade</button>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
