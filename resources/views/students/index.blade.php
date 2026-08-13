@extends('layouts.app')

@section('title', 'Student Directory - Student Management')

@section('content')
<!-- Top Action Bar -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div class="d-flex align-items-center gap-2">
        <span class="fw-bold text-dark fs-5">Student Directory</span>
        <span class="badge bg-dark rounded-pill px-2.5 py-1" style="font-size:.75rem;">
            Total: {{ $students->total() }}
        </span>
    </div>

    <div class="d-flex gap-1.5 flex-wrap">
        <!-- CSV Import -->
        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 shadow-xs d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#importCsvModal">
            <i class="bi bi-file-earmark-arrow-up"></i> Import
        </button>

        <!-- CSV Export -->
        <a href="{{ route('students.export-csv', request()->query()) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-xs d-flex align-items-center gap-1">
            <i class="bi bi-file-earmark-spreadsheet"></i> CSV
        </a>

        <!-- PDF Export -->
        <a href="{{ route('students.pdf', request()->query()) }}" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-xs d-flex align-items-center gap-1">
            <i class="bi bi-file-earmark-pdf-fill"></i> PDF
        </a>

        <!-- Add Student -->
        <a href="{{ route('students.create') }}" class="btn btn-sm btn-indigo rounded-pill px-3 shadow-xs d-flex align-items-center gap-1">
            <i class="bi bi-person-plus-fill"></i> Add Student
        </a>
    </div>
</div>

<!-- Unified Search & Filter Toolbar Card -->
<div class="card card-custom mb-3">
    <div class="card-body py-2 px-3">
        <form action="{{ route('students.index') }}" method="GET" class="row g-2 align-items-center">

            <!-- Search Bar -->
            <div class="col-lg-3 col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text border-end-0 bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search name, ID, email..." value="{{ $search }}">
                </div>
            </div>

            <!-- Year Level Dropdown Filter -->
            <div class="col-lg-2 col-md-3 col-6">
                <select name="year_level" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Year Levels ({{ $yearCounts['All'] }})</option>
                    @foreach($yearLevels as $year)
                        <option value="{{ $year }}" {{ $selectedYearLevel === $year ? 'selected' : '' }}>
                            {{ $year }} ({{ $yearCounts[$year] ?? 0 }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="col-lg-2 col-md-3 col-6">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $st)
                        <option value="{{ $st }}" {{ $selectedStatus === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Course Filter -->
            <div class="col-lg-2 col-md-3 col-6">
                <select name="course" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Courses</option>
                    @foreach($managedCourses as $mc)
                        <option value="{{ $mc->code }}" {{ $selectedCourse === $mc->code ? 'selected' : '' }}>{{ $mc->code }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By -->
            <div class="col-lg-2 col-md-3 col-6">
                <select name="sort_by" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="created_at" {{ $sortBy === 'created_at' ? 'selected' : '' }}>Sort: Date Added</option>
                    <option value="first_name" {{ $sortBy === 'first_name' ? 'selected' : '' }}>Sort: First Name</option>
                    <option value="last_name" {{ $sortBy === 'last_name' ? 'selected' : '' }}>Sort: Last Name</option>
                    <option value="student_number" {{ $sortBy === 'student_number' ? 'selected' : '' }}>Sort: ID</option>
                    <option value="gpa" {{ $sortBy === 'gpa' ? 'selected' : '' }}>Sort: GPA</option>
                    <option value="age" {{ $sortBy === 'age' ? 'selected' : '' }}>Sort: Age</option>
                </select>
            </div>

            <!-- Clear/Filter Actions -->
            <div class="col-lg-1 col-md-12 text-end d-flex gap-1 justify-content-end">
                <button type="submit" class="btn btn-sm btn-indigo px-2 shadow-xs" title="Apply Filter">
                    <i class="bi bi-funnel-fill"></i>
                </button>
                @if($search || $selectedStatus || $selectedCourse || $selectedYearLevel)
                    <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary px-2" title="Reset Filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Bulk Actions & Table Card -->
<form id="bulkForm" action="" method="POST">
    @csrf

    <div class="card card-custom border-0 overflow-hidden">
        {{-- Table Toolbar --}}
        <div class="card-header bg-white py-2 px-3 border-bottom border-light d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-indigo-subtle text-primary rounded-pill px-2.5 py-1 font-monospace small">
                    Showing: {{ $selectedYearLevel ? $selectedYearLevel : 'All Students' }}
                </span>
            </div>

            <div class="d-flex gap-1.5 align-items-center">
                <button type="button" class="btn btn-xs btn-outline-info rounded-pill px-2.5 py-1 d-flex align-items-center gap-1" style="font-size:.75rem;" onclick="submitBulkAction('{{ route('students.bulk-promote') }}', 'Are you sure you want to promote selected students to the next grade level?')">
                    <i class="bi bi-arrow-up-circle-fill"></i> Promote Selected
                </button>
                <button type="button" class="btn btn-xs btn-outline-danger rounded-pill px-2.5 py-1 d-flex align-items-center gap-1" style="font-size:.75rem;" onclick="submitBulkAction('{{ route('students.bulk-delete') }}', 'Are you sure you want to delete all selected students?')">
                    <i class="bi bi-trash-fill"></i> Delete Selected
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0" style="font-size:.8rem;">
                    <thead class="table-light">
                        <tr>
                            <th width="32px" class="ps-3">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th width="36px">Photo</th>
                            <th>ID Number</th>
                            <th>Student Name & Email</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Status</th>
                            <th>GPA</th>
                            <th width="80px" class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            @php
                                $yearBadge = match($student->year_level) {
                                    '1st Year' => 'badge-soft-primary',
                                    '2nd Year' => 'badge-soft-success',
                                    '3rd Year' => 'badge-soft-warning',
                                    '4th Year' => 'badge-soft-violet',
                                    default => 'badge-soft-dark'
                                };
                                $statusBadge = match($student->status) {
                                    'Active'    => 'badge-soft-success',
                                    'Graduated' => 'badge-soft-primary',
                                    'Dropped'   => 'badge-soft-danger',
                                    'On Leave'  => 'badge-soft-warning',
                                    default     => 'badge-soft-dark'
                                };
                            @endphp
                            <tr>
                                <td class="ps-3">
                                    <input type="checkbox" name="selected_students[]" value="{{ $student->id }}" class="form-check-input student-checkbox">
                                </td>
                                <td>
                                    <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}" class="rounded-circle" width="30" height="30" style="object-fit: cover;">
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace" style="font-size:.7rem;">{{ $student->student_number ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $student->name }}</div>
                                    <div class="text-muted" style="font-size:.7rem;">{{ $student->email }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border" style="font-size:.68rem;">{{ $student->course }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $yearBadge }} rounded-pill" style="font-size:.68rem;">
                                        {{ $student->year_level }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $statusBadge }} rounded-pill" style="font-size:.68rem;">
                                        {{ $student->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $student->gpa ? number_format($student->gpa, 2) : '—' }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-outline-warning p-0 px-1.5" title="Edit Student">
                                            <i class="bi bi-pencil-square" style="font-size:.75rem;"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger p-0 px-1.5" title="Delete Student" onclick="deleteSingleStudent('{{ route('students.destroy', $student->id) }}')">
                                            <i class="bi bi-trash-fill" style="font-size:.75rem;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <div class="py-2">
                                        <i class="bi bi-folder-x fs-3 text-secondary d-block mb-2"></i>
                                        <div class="fw-bold text-dark small">No student records found</div>
                                        <div class="text-muted" style="font-size:.75rem;">Try adjusting search or filters.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>




<!-- Single Student Delete Form Hidden Helper -->
<form id="singleDeleteForm" action="" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<div class="d-flex justify-content-center mt-4">
    {{ $students->links() }}
</div>

<!-- CSV Import Modal -->
<div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-success text-white py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-shape-sm bg-white text-success">
                        <i class="bi bi-file-earmark-arrow-up-fill icon-md"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0" id="importCsvModalLabel">Import Students from CSV</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('students.import-csv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        Upload a <code>.csv</code> file containing student records. Headers should include: 
                        <code>First Name, Middle Name, Last Name, Email, Course, Year Level, Status, Age</code>.
                    </p>
                    <div class="mb-3">
                        <label for="csv_file" class="form-label fw-semibold">Select CSV File</label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv,text/csv" required>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4 shadow-sm">
                        <i class="bi bi-cloud-upload me-1 icon-sm"></i> Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('selectAll')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    function submitBulkAction(actionUrl, confirmMessage) {
        const selected = document.querySelectorAll('.student-checkbox:checked');
        if (selected.length === 0) {
            alert('Please select at least one student checkbox.');
            return;
        }
        if (confirm(confirmMessage)) {
            const form = document.getElementById('bulkForm');
            form.action = actionUrl;
            form.submit();
        }
    }

    function deleteSingleStudent(deleteUrl) {
        if (confirm('Are you sure you want to delete this student record?')) {
            const form = document.getElementById('singleDeleteForm');
            form.action = deleteUrl;
            form.submit();
        }
    }
</script>
@endpush
@endsection
