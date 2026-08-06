@extends('layouts.app')
@section('title', 'Subjects - Student Management')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg bg-indigo-subtle shadow-sm"><i class="bi bi-journal-bookmark-fill icon-lg"></i></div>
        <div>
            <h2 class="fw-bold mb-0 text-dark">Subject Management</h2>
            <p class="text-muted small mb-0">Manage academic subjects offered in the system</p>
        </div>
    </div>
    <a href="{{ route('subjects.create') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus-circle-fill me-1 icon-sm"></i> Add Subject</a>
</div>
<div class="card card-custom border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead><tr><th class="ps-4">Code</th><th>Subject Name</th><th>Units</th><th>Description</th><th class="pe-4 text-end">Actions</th></tr></thead>
                <tbody>
                    @forelse($subjects as $subject)
                    <tr>
                        <td class="ps-4"><span class="badge bg-indigo-subtle text-primary font-monospace px-2.5 py-1.5">{{ $subject->code }}</span></td>
                        <td class="fw-bold text-dark">{{ $subject->name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $subject->units }} units</span></td>
                        <td class="text-secondary small">{{ $subject->description ?? '—' }}</td>
                        <td class="pe-4 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-outline-warning"><i class="bi bi-pencil-square icon-sm"></i> Edit</a>
                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this subject?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash-fill icon-sm"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-5 text-muted">No subjects added yet. <a href="{{ route('subjects.create') }}">Add one now</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">{{ $subjects->links() }}</div>
@endsection
