@extends('layouts.app')

@section('title', 'Dashboard - Student Management')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <div class="icon-shape-lg bg-indigo-subtle shadow-sm">
        <i class="bi bi-speedometer2 icon-lg"></i>
    </div>
    <div>
        <h2 class="fw-bold mb-0 text-dark">Dashboard</h2>
        <p class="text-muted small mb-0">
            System overview
            @if($activeSemester)
                &mdash; Active: <span class="badge bg-indigo-subtle text-primary">{{ $activeSemester->label }}</span>
            @else
                &mdash; <span class="badge bg-warning text-dark">No active semester set</span>
            @endif
        </p>
    </div>
</div>

<!-- Stat Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom border-0 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-shape-lg shadow-sm" style="background: #eef2ff;">
                    <i class="bi bi-people-fill icon-lg" style="color: #4f46e5;"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-dark">{{ $totalStudents }}</div>
                    <div class="text-muted small">Total Students</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom border-0 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-shape-lg shadow-sm" style="background: #dcfce7;">
                    <i class="bi bi-person-check-fill icon-lg" style="color: #16a34a;"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-dark">{{ $activeStudents }}</div>
                    <div class="text-muted small">Active Students</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom border-0 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-shape-lg shadow-sm" style="background: #dbeafe;">
                    <i class="bi bi-mortarboard-fill icon-lg" style="color: #2563eb;"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-dark">{{ $graduatedStudents }}</div>
                    <div class="text-muted small">Graduated</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom border-0 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-shape-lg shadow-sm" style="background: #fef9c3;">
                    <i class="bi bi-star-fill icon-lg" style="color: #ca8a04;"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-dark">{{ $averageGpa ? number_format($averageGpa, 2) : 'N/A' }}</div>
                    <div class="text-muted small">Average GPA</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Today Row -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 card-custom text-center py-3">
            <div class="fw-bold fs-3 text-success">{{ $todayPresent }}</div>
            <div class="small text-muted"><i class="bi bi-check-circle-fill text-success me-1"></i> Present Today</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 card-custom text-center py-3">
            <div class="fw-bold fs-3 text-danger">{{ $todayAbsent }}</div>
            <div class="small text-muted"><i class="bi bi-x-circle-fill text-danger me-1"></i> Absent Today</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 card-custom text-center py-3">
            <div class="fw-bold fs-3 text-warning">{{ $todayLate }}</div>
            <div class="small text-muted"><i class="bi bi-clock-fill text-warning me-1"></i> Late Today</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card card-custom border-0 h-100">
            <div class="card-header bg-white border-bottom border-light py-3">
                <h6 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart-fill text-indigo icon-md"></i> Students per Course
                </h6>
            </div>
            <div class="card-body">
                <canvas id="courseChart" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-custom border-0 h-100">
            <div class="card-header bg-white border-bottom border-light py-3">
                <h6 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-pie-chart-fill text-violet icon-md"></i> Students per Year Level
                </h6>
            </div>
            <div class="card-body">
                <canvas id="yearChart" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-custom border-0 h-100">
            <div class="card-header bg-white border-bottom border-light py-3">
                <h6 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-donut text-cyan icon-md"></i> Students per Status
                </h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="statusChart" height="220"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-custom border-0 h-100">
            <div class="card-header bg-white border-bottom border-light py-3">
                <h6 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-trophy-fill text-amber icon-md"></i> Top 5 GPA Students
                </h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($topStudents as $i => $student)
                    <li class="list-group-item d-flex align-items-center gap-3 px-4 py-3">
                        <span class="fw-bold fs-5 text-muted" style="width: 28px;">{{ $i + 1 }}</span>
                        <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}" class="rounded-circle" width="36" height="36" style="object-fit:cover;">
                        <div class="flex-grow-1">
                            <div class="fw-bold small text-dark">{{ $student->name }}</div>
                            <div class="text-muted" style="font-size:0.75rem;">{{ $student->course }} &mdash; {{ $student->year_level }}</div>
                        </div>
                        <span class="badge bg-success rounded-pill px-3">{{ number_format($student->gpa, 2) }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted py-4">No GPA data available yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Recent Students -->
<div class="card card-custom border-0">
    <div class="card-header bg-white border-bottom border-light py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
            <i class="bi bi-clock-history text-indigo icon-md"></i> Recently Added Students
        </h6>
        <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            @foreach($recentStudents as $student)
            <li class="list-group-item d-flex align-items-center gap-3 px-4 py-3">
                <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}" class="rounded-circle" width="40" height="40" style="object-fit:cover;">
                <div class="flex-grow-1">
                    <div class="fw-bold text-dark">{{ $student->name }}</div>
                    <div class="text-muted small">{{ $student->student_number }} &mdash; {{ $student->course }}</div>
                </div>
                <span class="badge badge-soft-{{ $student->status === 'Active' ? 'success' : 'secondary' }} rounded-pill">{{ $student->status }}</span>
                <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                    <i class="bi bi-eye icon-sm"></i>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Students per Course - Bar Chart
new Chart(document.getElementById('courseChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($courseData->keys()) !!},
        datasets: [{
            label: 'Students',
            data: {!! json_encode($courseData->values()) !!},
            backgroundColor: ['#4f46e5','#7c3aed','#0891b2','#059669','#d97706','#dc2626','#475569','#be185d'],
            borderRadius: 8,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});

// Students per Year Level - Doughnut Chart
new Chart(document.getElementById('yearChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($yearLevelData->keys()) !!},
        datasets: [{
            data: {!! json_encode($yearLevelData->values()) !!},
            backgroundColor: ['#4f46e5','#16a34a','#d97706','#7c3aed'],
            borderWidth: 3,
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

// Students per Status - Pie Chart
new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($statusData->keys()) !!},
        datasets: [{
            data: {!! json_encode($statusData->values()) !!},
            backgroundColor: ['#16a34a','#2563eb','#dc2626','#d97706'],
            borderWidth: 3,
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endpush
@endsection
