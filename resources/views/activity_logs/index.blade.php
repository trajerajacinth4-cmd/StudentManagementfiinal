@extends('layouts.app')

@section('title', 'System Audit Logs - Student Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg bg-indigo-subtle shadow-sm">
            <i class="bi bi-journal-text icon-lg"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0 text-dark tracking-tight">System Audit Logs</h2>
            <p class="text-muted small mb-0">History of administrative events, data modifications, and system activities</p>
        </div>
    </div>
    <div>
        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1.5">
            <i class="bi bi-arrow-left icon-sm"></i> Back to Directory
        </a>
    </div>
</div>

<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header bg-white py-3 border-bottom border-light">
        <h5 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
            <i class="bi bi-clock-history text-indigo icon-md"></i> Activity History
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Timestamp</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th class="pe-4">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        @php
                            $actionBadge = match($log->action) {
                                'CREATE_STUDENT' => 'badge-soft-success',
                                'UPDATE_STUDENT' => 'badge-soft-warning',
                                'DELETE_STUDENT' => 'badge-soft-danger',
                                'BULK_DELETE'    => 'badge-soft-danger',
                                'BULK_PROMOTE'   => 'badge-soft-violet',
                                'CSV_IMPORT'     => 'badge-soft-primary',
                                'CSV_EXPORT'     => 'badge-soft-cyan',
                                default          => 'badge-soft-dark'
                            };
                        @endphp
                        <tr>
                            <td class="ps-4 text-nowrap">
                                <span class="fw-semibold text-secondary small">
                                    <i class="bi bi-calendar3 text-muted me-1 icon-sm"></i>{{ $log->created_at->format('Y-m-d H:i:s') }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">
                                <i class="bi bi-person-circle text-indigo me-1 icon-sm"></i>{{ $log->user_name }}
                            </td>
                            <td>
                                <span class="badge {{ $actionBadge }} px-2.5 py-1.5 rounded-pill">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="text-secondary small">{{ $log->description }}</td>
                            <td class="pe-4 text-nowrap text-muted small">
                                <i class="bi bi-laptop me-1 icon-sm"></i>{{ $log->ip_address ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <div class="icon-shape-lg bg-indigo-subtle rounded-circle mb-3 mx-auto">
                                        <i class="bi bi-journal-x icon-xl text-primary"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">No activity logs recorded yet</h5>
                                    <p class="small text-muted">Administrative actions will automatically appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $logs->links() }}
</div>
@endsection
