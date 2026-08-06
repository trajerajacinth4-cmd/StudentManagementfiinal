@extends('layouts.app')
@section('title', 'Semesters - Student Management')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg bg-cyan-subtle shadow-sm"><i class="bi bi-calendar3 icon-lg text-cyan"></i></div>
        <div>
            <h2 class="fw-bold mb-0 text-dark">Semester Management</h2>
            <p class="text-muted small mb-0">Manage school years and semesters</p>
        </div>
    </div>
    <a href="{{ route('semesters.create') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus-circle-fill me-1 icon-sm"></i> Add Semester</a>
</div>
<div class="card card-custom border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead><tr><th class="ps-4">Semester</th><th>School Year</th><th>Status</th><th class="pe-4 text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($semesters as $semester)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $semester->name }}</td>
                        <td><span class="badge bg-indigo-subtle text-primary px-3">S.Y. {{ $semester->school_year }}</span></td>
                        <td>
                            @if($semester->is_active)
                                <span class="badge badge-soft-success rounded-pill px-3"><i class="bi bi-record-fill me-1"></i>Active</span>
                            @else
                                <span class="badge badge-soft-secondary rounded-pill px-3">Inactive</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex gap-1 justify-content-end flex-wrap">
                                @if(!$semester->is_active)
                                <form action="{{ route('semesters.activate', $semester->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Set as Active Semester"><i class="bi bi-check-circle icon-sm"></i> Activate</button>
                                </form>
                                @endif
                                <a href="{{ route('semesters.edit', $semester->id) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil-square icon-sm"></i> Edit</a>
                                <form action="{{ route('semesters.destroy', $semester->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this semester?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash-fill icon-sm"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5 text-muted">No semesters added yet. <a href="{{ route('semesters.create') }}">Add one now</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $semesters->links() }}</div>
@endsection
