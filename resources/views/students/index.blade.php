@extends('layouts.app')

@section('title', 'Student Directory - Student Management')

@section('content')
<!-- Header Title & Action Buttons -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg bg-indigo-subtle shadow-sm">
            <i class="bi bi-people-fill icon-lg"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0 text-dark tracking-tight">Student Directory</h2>
            <p class="text-muted small mb-0">Search, filter, manage, and promote student records</p>
        </div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <!-- CSV Import Modal Trigger -->
        <button type="button" class="btn btn-outline-success shadow-sm d-flex align-items-center gap-1.5" data-bs-toggle="modal" data-bs-target="#importCsvModal">
            <i class="bi bi-file-earmark-arrow-up icon-sm text-success"></i> Import CSV
        </button>

        <!-- CSV Export -->
        <a href="{{ route('students.export-csv', request()->query()) }}" class="btn btn-outline-secondary shadow-sm d-flex align-items-center gap-1.5">
            <i class="bi bi-file-earmark-spreadsheet icon-sm text-secondary"></i> Export CSV
        </a>

        <!-- PDF Export -->
        <a href="{{ route('students.pdf', request()->query()) }}" class="btn btn-outline-danger shadow-sm d-flex align-items-center gap-1.5">
            <i class="bi bi-file-earmark-pdf-fill icon-sm text-danger"></i> Download PDF
        </a>

        <!-- Add Student -->
        <a href="{{ route('students.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center gap-1.5">
            <i class="bi bi-person-plus-fill icon-sm"></i> Add Student
        </a>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="card card-custom mb-4">
    <div class="card-body p-3">
        <form action="{{ route('students.index') }}" method="GET" class="row g-2 align-items-center">
            @if($selectedYearLevel)
                <input type="hidden" name="year_level" value="{{ $selectedYearLevel }}">
            @endif

            <!-- Live Search Bar -->
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-white"><i class="bi bi-search text-muted icon-sm"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search Name, Email, Course, or ID..." value="{{ $search }}">
                </div>
            </div>

            <!-- Status Filter -->
            <div class="col-md-2 col-6">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach($statuses as $st)
                        <option value="{{ $st }}" {{ $selectedStatus === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Course Filter -->
            <div class="col-md-2 col-6">
                <select name="course" class="form-select">
                    <option value="">All Courses</option>
                    @foreach($managedCourses as $mc)
                        <option value="{{ $mc->code }}" {{ $selectedCourse === $mc->code ? 'selected' : '' }}>{{ $mc->code }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By -->
            <div class="col-md-2 col-6">
                <select name="sort_by" class="form-select">
                    <option value="created_at" {{ $sortBy === 'created_at' ? 'selected' : '' }}>Sort: Date Added</option>
                    <option value="first_name" {{ $sortBy === 'first_name' ? 'selected' : '' }}>Sort: First Name</option>
                    <option value="last_name" {{ $sortBy === 'last_name' ? 'selected' : '' }}>Sort: Last Name</option>
                    <option value="student_number" {{ $sortBy === 'student_number' ? 'selected' : '' }}>Sort: Student ID</option>
                    <option value="gpa" {{ $sortBy === 'gpa' ? 'selected' : '' }}>Sort: GPA</option>
                    <option value="age" {{ $sortBy === 'age' ? 'selected' : '' }}>Sort: Age</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="col-md-2 col-6 d-flex gap-1">
                <button type="submit" class="btn btn-primary flex-grow-1 shadow-sm d-flex align-items-center justify-content-center gap-1">
                    <i class="bi bi-funnel-fill icon-sm"></i> Filter
                </button>
                @if($search || $selectedStatus || $selectedCourse || $selectedYearLevel)
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" title="Reset Filters">
                        <i class="bi bi-x-lg icon-sm"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Year Level Navigation Interface -->
<div class="card card-custom mb-4">
    <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <span class="fw-bold text-secondary me-2 small uppercase tracking-wider d-flex align-items-center gap-1">
                <i class="bi bi-mortarboard-fill text-indigo icon-sm"></i> Year Level:
            </span>
            <ul class="nav nav-pills flex-grow-1 gap-1">
                <li class="nav-item">
                    <a href="{{ route('students.index', array_merge(request()->except('year_level', 'page'), [])) }}" 
                       class="nav-link rounded-pill px-3 py-1.5 small {{ !$selectedYearLevel ? 'active bg-dark text-white fw-bold shadow-sm' : 'text-dark bg-light' }}">
                        All Students 
                        <span class="badge rounded-pill {{ !$selectedYearLevel ? 'bg-white text-dark' : 'bg-secondary text-white' }} ms-1">
                            {{ $yearCounts['All'] }}
                        </span>
                    </a>
                </li>
                @foreach($yearLevels as $year)
                    @php
                        $badgeClass = match($year) {
                            '1st Year' => 'badge-soft-primary',
                            '2nd Year' => 'badge-soft-success',
                            '3rd Year' => 'badge-soft-warning',
                            '4th Year' => 'badge-soft-violet',
                            default => 'badge-soft-cyan'
                        };
                    @endphp
                    <li class="nav-item">
                        <a href="{{ route('students.index', array_merge(request()->except('page'), ['year_level' => $year])) }}" 
                           class="nav-link rounded-pill px-3 py-1.5 small {{ $selectedYearLevel === $year ? 'active bg-indigo text-white fw-bold shadow-sm' : 'text-dark bg-light' }}">
                            {{ $year }}
                            <span class="badge rounded-pill {{ $selectedYearLevel === $year ? 'bg-white text-dark' : 'bg-secondary text-white' }} ms-1">
                                {{ $yearCounts[$year] }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Bulk Actions Form & Student List Table -->
<form id="bulkForm" action="" method="POST">
    @csrf

    <div class="card card-custom border-0 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-indigo-subtle text-primary rounded-pill px-3 py-1.5 fw-bold small">
                        Showing: {{ $selectedYearLevel ? $selectedYearLevel : 'All Students' }}
                    </span>
                </div>

                <!-- Bulk Actions Buttons -->
                <div class="d-flex gap-2 align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-info rounded-pill d-flex align-items-center gap-1" onclick="submitBulkAction('{{ route('students.bulk-promote') }}', 'Are you sure you want to promote selected students to the next grade level?')">
                        <i class="bi bi-arrow-up-circle-fill icon-sm"></i> Bulk Promote
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill d-flex align-items-center gap-1" onclick="submitBulkAction('{{ route('students.bulk-delete') }}', 'Are you sure you want to delete all selected students?')">
                        <i class="bi bi-trash-fill icon-sm"></i> Bulk Delete
                    </button>
                    <span class="badge bg-dark rounded-pill px-3 py-1.5 ms-2">
                        Total: {{ $students->total() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="40px" class="ps-3">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th width="60px">Photo</th>
                            <th>Student ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Year Level</th>
                            <th>Status</th>
                            <th>GPA</th>
                            <th width="120px" class="text-end pe-4">Actions</th>
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
                                    <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}" class="rounded-circle border border-2 border-white shadow-sm" width="40" height="40" style="object-fit: cover;">
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace">{{ $student->student_number ?? 'N/A' }}</span>
                                </td>
                                <td class="fw-bold text-dark">{{ $student->name }}</td>
                                <td>
                                    <a href="mailto:{{ $student->email }}" class="text-decoration-none text-muted small">
                                        <i class="bi bi-envelope me-1 text-secondary icon-sm"></i>{{ $student->email }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border">
                                        <i class="bi bi-book me-1 icon-sm"></i>{{ $student->course }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $yearBadge }} px-2.5 py-1.5 rounded-pill">
                                        {{ $student->year_level }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $statusBadge }} px-2.5 py-1.5 rounded-pill">
                                        <i class="bi bi-record-fill me-1 icon-sm"></i>{{ $student->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $student->gpa ? number_format($student->gpa, 2) : 'N/A' }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-outline-warning rounded-start" title="Edit Student">
                                            <i class="bi bi-pencil-square icon-sm"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger rounded-end" title="Delete Student" onclick="deleteSingleStudent('{{ route('students.destroy', $student->id) }}')">
                                            <i class="bi bi-trash-fill icon-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <div class="py-4">
                                        <div class="icon-shape-lg bg-indigo-subtle rounded-circle mb-3 mx-auto">
                                            <i class="bi bi-folder-x icon-xl text-primary"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">No student records found</h5>
                                        <p class="small text-muted mb-3">Try adjusting your search criteria or add a new student profile.</p>
                                        <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                                            <i class="bi bi-plus-lg me-1 icon-sm"></i>Add Student Now
                                        </a>
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
