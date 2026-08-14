@extends('layouts.app')

@section('title', 'Dashboard - Student Management')

@section('content')

{{-- ── Interactive Filter Strip (Year Level + Course) ── --}}
<div class="card card-custom border-0 mb-3 bg-white shadow-sm">
    <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center flex-wrap gap-3">
            {{-- Year Level Filter --}}
            <div class="d-flex align-items-center gap-1.5">
                <span class="fw-bold text-secondary small d-flex align-items-center gap-1">
                    <i class="bi bi-mortarboard-fill text-indigo"></i> Year:
                </span>
                <div class="btn-group btn-group-sm" role="group" id="yearFilterGroup">
                    <button type="button" class="btn btn-indigo active rounded-pill px-2.5 py-1 me-1 shadow-xs fw-semibold" data-year="All">All</button>
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-2.5 py-1 me-1 shadow-xs" data-year="1st Year">1st Year</button>
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-2.5 py-1 me-1 shadow-xs" data-year="2nd Year">2nd Year</button>
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-2.5 py-1 me-1 shadow-xs" data-year="3rd Year">3rd Year</button>
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-2.5 py-1 me-1 shadow-xs" data-year="4th Year">4th Year</button>
                </div>
            </div>

            {{-- Course Filter --}}
            <div class="d-flex align-items-center gap-1.5">
                <span class="fw-bold text-secondary small d-flex align-items-center gap-1">
                    <i class="bi bi-book-fill text-primary"></i> Course:
                </span>
                <div class="btn-group btn-group-sm flex-wrap" role="group" id="courseFilterGroup">
                    <button type="button" class="btn btn-indigo active rounded-pill px-2.5 py-1 me-1 shadow-xs fw-semibold" data-course="All">All Courses</button>
                    @foreach($coursesList as $c)
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-2.5 py-1 me-1 shadow-xs" data-course="{{ $c }}">{{ $c }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="small text-muted ms-auto" id="filterStatusLabel">
            Showing <strong class="text-dark" id="filteredCountText">{{ $totalStudents }}</strong> students
            <button type="button" class="btn btn-link text-decoration-none text-muted p-0 ms-2 small d-none" id="resetFiltersBtn" title="Reset all filters">
                <i class="bi bi-x-circle-fill"></i> Reset
            </button>
        </div>
    </div>
</div>


{{-- ── Compact Stat Strip ── --}}
<div class="card card-custom border-0 mb-3">
    <div class="card-body p-0">
        <div class="d-flex flex-wrap">
            <a href="{{ route('students.index') }}" class="text-decoration-none flex-grow-1" style="min-width:100px; border-right: 1px solid #f1f5f9;">
                <div class="d-flex align-items-center gap-2 px-3 py-2 h-100" onmouseenter="this.style.background='#f8fafc'" onmouseleave="this.style.background=''">
                    <i class="bi bi-people-fill text-indigo" style="font-size:.9rem;"></i>
                    <div>
                        <div class="fw-bold text-dark lh-1" style="font-size:1.05rem;" id="statTotal">{{ $totalStudents }}</div>
                        <div class="text-muted lh-1 mt-1" style="font-size:.68rem;">Total</div>
                    </div>
                </div>
            </a>
            <a href="{{ route('students.index', ['status'=>'Active']) }}" class="text-decoration-none flex-grow-1" style="min-width:100px; border-right: 1px solid #f1f5f9;">
                <div class="d-flex align-items-center gap-2 px-3 py-2 h-100" onmouseenter="this.style.background='#f8fafc'" onmouseleave="this.style.background=''">
                    <i class="bi bi-person-check-fill text-success" style="font-size:.9rem;"></i>
                    <div>
                        <div class="fw-bold text-dark lh-1" style="font-size:1.05rem;" id="statActive">{{ $activeStudents }}</div>
                        <div class="text-muted lh-1 mt-1" style="font-size:.68rem;">Active</div>
                    </div>
                </div>
            </a>
            <a href="{{ route('students.index', ['status'=>'Graduated']) }}" class="text-decoration-none flex-grow-1" style="min-width:100px; border-right: 1px solid #f1f5f9;">
                <div class="d-flex align-items-center gap-2 px-3 py-2 h-100" onmouseenter="this.style.background='#f8fafc'" onmouseleave="this.style.background=''">
                    <i class="bi bi-mortarboard-fill text-primary" style="font-size:.9rem;"></i>
                    <div>
                        <div class="fw-bold text-dark lh-1" style="font-size:1.05rem;" id="statGraduated">{{ $graduatedStudents }}</div>
                        <div class="text-muted lh-1 mt-1" style="font-size:.68rem;">Graduated</div>
                    </div>
                </div>
            </a>
            <a href="{{ route('students.honor-roll') }}" class="text-decoration-none flex-grow-1" style="min-width:100px;">
                <div class="d-flex align-items-center gap-2 px-3 py-2 h-100" onmouseenter="this.style.background='#f8fafc'" onmouseleave="this.style.background=''">
                    <i class="bi bi-star-fill text-warning" style="font-size:.9rem;"></i>
                    <div>
                        <div class="fw-bold text-dark lh-1" style="font-size:1.05rem;" id="statAvgGpa">{{ $averageGpa ? number_format($averageGpa,2) : '—' }}</div>
                        <div class="text-muted lh-1 mt-1" style="font-size:.68rem;">Avg GPA</div>
                    </div>
                </div>
            </a>

            {{-- Semester indicator --}}
            <div class="px-3 py-2 d-flex align-items-center border-start" style="border-color:#f1f5f9 !important;">
                <div>
                    <div class="text-muted lh-1" style="font-size:.65rem;">SEMESTER</div>
                    <div class="lh-1 mt-1" style="font-size:.75rem;">
                        @if($activeSemester)
                            <span class="badge bg-indigo-subtle text-primary fw-semibold">{{ $activeSemester->label }}</span>
                        @else
                            <span class="badge bg-warning text-dark fw-semibold">None set</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Charts + Top Students (3-column) ── --}}
<div class="row g-3 mb-3">

    {{-- Bar Chart: Students per Course --}}
    <div class="col-lg-4 col-md-6">
        <div class="card card-custom border-0 h-100">
            <div class="card-header bg-white border-bottom border-light py-2 px-3">
                <span class="fw-semibold text-secondary small d-flex align-items-center gap-1">
                    <i class="bi bi-bar-chart-fill text-indigo" style="font-size:.8rem;"></i> Per Course
                </span>
            </div>
            <div class="card-body p-2">
                <canvas id="courseChart" height="160"></canvas>
            </div>
        </div>
    </div>

    {{-- Doughnut: Per Year Level + Pie: Per Status stacked --}}
    <div class="col-lg-4 col-md-6 d-flex flex-column gap-3">
        <div class="card card-custom border-0 flex-grow-1">
            <div class="card-header bg-white border-bottom border-light py-2 px-3">
                <span class="fw-semibold text-secondary small d-flex align-items-center gap-1">
                    <i class="bi bi-pie-chart-fill text-violet" style="font-size:.8rem;"></i> Year Level Distribution
                </span>
            </div>
            <div class="card-body p-2 d-flex align-items-center justify-content-center">
                <canvas id="yearChart" height="120"></canvas>
            </div>
        </div>
        <div class="card card-custom border-0 flex-grow-1">
            <div class="card-header bg-white border-bottom border-light py-2 px-3">
                <span class="fw-semibold text-secondary small d-flex align-items-center gap-1">
                    <i class="bi bi-circle-fill text-cyan" style="font-size:.8rem;"></i> Status Breakdown
                </span>
            </div>
            <div class="card-body p-2 d-flex align-items-center justify-content-center">
                <canvas id="statusChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Top 5 GPA --}}
    <div class="col-lg-4 col-md-12">
        <div class="card card-custom border-0 h-100">
            <div class="card-header bg-white border-bottom border-light py-2 px-3">
                <span class="fw-semibold text-secondary small d-flex align-items-center gap-1">
                    <i class="bi bi-trophy-fill text-amber" style="font-size:.8rem;"></i> Top GPA (<span id="topGpaFilterLabel">All</span>)
                </span>
            </div>
            <div class="card-body p-0" id="topGpaContainer">
                {{-- Populated by JS --}}
            </div>
        </div>
    </div>
</div>

{{-- ── Recent Students (compact table) ── --}}
<div class="card card-custom border-0">
    <div class="card-header bg-white border-bottom border-light py-2 px-3 d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-secondary small d-flex align-items-center gap-1">
            <i class="bi bi-clock-history text-indigo" style="font-size:.8rem;"></i> Recent Students (<span id="recentFilterLabel">All</span>)
        </span>
        <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-0" style="font-size:.72rem;">
            View All
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0" style="font-size:.8rem;">
                <tbody id="recentStudentsContainer">
                    {{-- Populated by JS --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.allStudentsData = {!! json_encode($allStudents) !!};

let courseChart, yearChart, statusChart;
let currentYearFilter = 'All';
let currentCourseFilter = 'All';

const chartDefaults = {
    responsive: true,
    maintainAspectRatio: true,
    plugins: { legend: { display: false } }
};

function initCharts() {
    // Bar: Per Course
    courseChart = new Chart(document.getElementById('courseChart'), {
        type: 'bar',
        data: { labels: [], datasets: [{ label: 'Students', data: [], backgroundColor: ['#4f46e5','#7c3aed','#0891b2','#059669','#d97706','#dc2626','#475569','#be185d'], borderRadius: 5, barThickness: 18 }] },
        options: { ...chartDefaults, scales: { y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10 } }, grid: { color: '#f1f5f9' } }, x: { ticks: { font: { size: 10 } }, grid: { display: false } } } }
    });

    // Doughnut: Year Level
    yearChart = new Chart(document.getElementById('yearChart'), {
        type: 'doughnut',
        data: { labels: [], datasets: [{ data: [], backgroundColor: ['#4f46e5','#16a34a','#d97706','#7c3aed'], borderWidth: 2 }] },
        options: { ...chartDefaults, plugins: { legend: { display: true, position: 'bottom', labels: { boxWidth: 10, font: { size: 10 }, padding: 6 } } }, cutout: '65%' }
    });

    // Pie: Status
    statusChart = new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: { labels: [], datasets: [{ data: [], backgroundColor: ['#16a34a','#2563eb','#dc2626','#d97706'], borderWidth: 2 }] },
        options: { ...chartDefaults, plugins: { legend: { display: true, position: 'bottom', labels: { boxWidth: 10, font: { size: 10 }, padding: 6 } } } }
    });
}

function updateDashboard() {
    const students = window.allStudentsData || [];
    const filtered = students.filter(s => {
        const matchYear = currentYearFilter === 'All' || s.year_level === currentYearFilter;
        const matchCourse = currentCourseFilter === 'All' || s.course === currentCourseFilter;
        return matchYear && matchCourse;
    });

    // Show/hide reset button
    const isFiltered = currentYearFilter !== 'All' || currentCourseFilter !== 'All';
    const resetBtn = document.getElementById('resetFiltersBtn');
    if (resetBtn) {
        if (isFiltered) resetBtn.classList.remove('d-none');
        else resetBtn.classList.add('d-none');
    }

    // Filter label text
    const labelParts = [];
    if (currentYearFilter !== 'All') labelParts.push(currentYearFilter);
    if (currentCourseFilter !== 'All') labelParts.push(currentCourseFilter);
    const filterText = labelParts.length > 0 ? labelParts.join(' · ') : 'All';

    document.getElementById('filteredCountText').innerText = filtered.length;
    document.getElementById('statTotal').innerText = filtered.length;
    
    const activeCount = filtered.filter(s => s.status === 'Active').length;
    const graduatedCount = filtered.filter(s => s.status === 'Graduated').length;
    document.getElementById('statActive').innerText = activeCount;
    document.getElementById('statGraduated').innerText = graduatedCount;

    const gpas = filtered.filter(s => s.gpa !== null && s.gpa !== undefined).map(s => parseFloat(s.gpa));
    const avgGpa = gpas.length > 0 ? (gpas.reduce((a,b) => a+b, 0) / gpas.length).toFixed(2) : '—';
    document.getElementById('statAvgGpa').innerText = avgGpa;

    document.getElementById('topGpaFilterLabel').innerText = filterText;
    document.getElementById('recentFilterLabel').innerText = filterText;

    // Update Course Chart
    const courseCounts = {};
    filtered.forEach(s => {
        const c = s.course || 'Unassigned';
        courseCounts[c] = (courseCounts[c] || 0) + 1;
    });
    courseChart.data.labels = Object.keys(courseCounts);
    courseChart.data.datasets[0].data = Object.values(courseCounts);
    courseChart.update();

    // Update Year Level Chart
    const yearCounts = {};
    filtered.forEach(s => {
        const y = s.year_level || 'Unassigned';
        yearCounts[y] = (yearCounts[y] || 0) + 1;
    });
    yearChart.data.labels = Object.keys(yearCounts);
    yearChart.data.datasets[0].data = Object.values(yearCounts);
    yearChart.update();

    // Update Status Chart
    const statusCounts = {};
    filtered.forEach(s => {
        const st = s.status || 'Active';
        statusCounts[st] = (statusCounts[st] || 0) + 1;
    });
    statusChart.data.labels = Object.keys(statusCounts);
    statusChart.data.datasets[0].data = Object.values(statusCounts);
    statusChart.update();

    // Update Top 5 GPA Container
    const topGpaStudents = [...filtered]
        .filter(s => s.gpa !== null && s.gpa !== undefined && s.status === 'Active')
        .sort((a,b) => parseFloat(b.gpa) - parseFloat(a.gpa))
        .slice(0, 5);

    const topGpaContainer = document.getElementById('topGpaContainer');
    if (topGpaStudents.length === 0) {
        topGpaContainer.innerHTML = `<div class="text-center text-muted py-4 small">No GPA data available for ${escapeHtml(filterText)}.</div>`;
    } else {
        topGpaContainer.innerHTML = topGpaStudents.map((s, i) => `
            <div class="d-flex align-items-center gap-2 px-3 py-2 ${i < topGpaStudents.length - 1 ? 'border-bottom border-light' : ''}">
                <span class="text-muted fw-bold" style="font-size:.75rem;width:16px;">${i + 1}</span>
                <img src="${s.avatar_url}" class="rounded-circle flex-shrink-0" width="28" height="28" style="object-fit:cover;">
                <div class="flex-grow-1 overflow-hidden">
                    <div class="fw-semibold text-dark text-truncate" style="font-size:.8rem;">${escapeHtml(s.name)}</div>
                    <div class="text-muted text-truncate" style="font-size:.68rem;">${escapeHtml(s.course)} · ${escapeHtml(s.year_level)}</div>
                </div>
                <span class="badge bg-success rounded-pill" style="font-size:.68rem;">${parseFloat(s.gpa).toFixed(2)}</span>
            </div>
        `).join('');
    }

    // Update Recent Students Table
    const recentStudents = [...filtered].slice(0, 5);
    const recentContainer = document.getElementById('recentStudentsContainer');

    if (recentStudents.length === 0) {
        recentContainer.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-3">No students found for ${escapeHtml(filterText)}.</td></tr>`;
    } else {
        recentContainer.innerHTML = recentStudents.map(s => {
            const badgeClass = s.status === 'Active' ? 'success' : (s.status === 'Graduated' ? 'primary' : (s.status === 'Dropped' ? 'danger' : 'warning'));
            return `
                <tr>
                    <td class="ps-3" width="36">
                        <img src="${s.avatar_url}" class="rounded-circle" width="28" height="28" style="object-fit:cover;">
                    </td>
                    <td class="fw-semibold text-dark">${escapeHtml(s.name)}</td>
                    <td class="text-muted d-none d-md-table-cell">${escapeHtml(s.student_number || '')}</td>
                    <td class="d-none d-sm-table-cell">
                        <span class="badge bg-light text-secondary border" style="font-size:.67rem;">${escapeHtml(s.course)}</span>
                    </td>
                    <td>
                        <span class="badge badge-soft-${badgeClass} rounded-pill" style="font-size:.67rem;">${escapeHtml(s.status)}</span>
                    </td>
                    <td class="pe-3 text-end">
                        <a href="/students/${s.id}" class="btn btn-sm btn-outline-secondary rounded-pill p-0 px-2" style="font-size:.7rem;">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            `;
        }).join('');
    }
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

document.addEventListener('DOMContentLoaded', function() {
    initCharts();
    updateDashboard();

    // Attach click handlers to Year filter buttons
    const yearButtons = document.querySelectorAll('#yearFilterGroup button');
    yearButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            yearButtons.forEach(b => {
                b.classList.remove('btn-indigo', 'active', 'text-white');
                b.classList.add('btn-outline-secondary');
            });
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-indigo', 'active', 'text-white');

            currentYearFilter = this.getAttribute('data-year');
            updateDashboard();
        });
    });

    // Attach click handlers to Course filter buttons
    const courseButtons = document.querySelectorAll('#courseFilterGroup button');
    courseButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            courseButtons.forEach(b => {
                b.classList.remove('btn-indigo', 'active', 'text-white');
                b.classList.add('btn-outline-secondary');
            });
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-indigo', 'active', 'text-white');

            currentCourseFilter = this.getAttribute('data-course');
            updateDashboard();
        });
    });

    // Reset filters handler
    const resetBtn = document.getElementById('resetFiltersBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            currentYearFilter = 'All';
            currentCourseFilter = 'All';

            yearButtons.forEach(b => {
                b.classList.remove('btn-indigo', 'active', 'text-white');
                b.classList.add('btn-outline-secondary');
                if (b.getAttribute('data-year') === 'All') {
                    b.classList.remove('btn-outline-secondary');
                    b.classList.add('btn-indigo', 'active', 'text-white');
                }
            });

            courseButtons.forEach(b => {
                b.classList.remove('btn-indigo', 'active', 'text-white');
                b.classList.add('btn-outline-secondary');
                if (b.getAttribute('data-course') === 'All') {
                    b.classList.remove('btn-outline-secondary');
                    b.classList.add('btn-indigo', 'active', 'text-white');
                }
            });

            updateDashboard();
        });
    }
});
</script>
@endpush
@endsection

