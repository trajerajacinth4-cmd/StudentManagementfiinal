<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Profile — {{ $student->name }}</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
    .header { background: #4f46e5; color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
    .header h1 { margin: 0; font-size: 20px; }
    .header p { margin: 4px 0 0; font-size: 12px; opacity: 0.85; }
    .badge { background: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 20px; font-size: 11px; }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 20px; }
    .info-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; text-align: center; }
    .info-card .value { font-size: 22px; font-weight: bold; color: #4f46e5; }
    .info-card .label { font-size: 10px; color: #64748b; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th { background: #f1f5f9; padding: 8px 10px; text-align: left; font-size: 11px; text-transform: uppercase; color: #64748b; border-bottom: 2px solid #e2e8f0; }
    td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; }
    .section-title { font-size: 13px; font-weight: bold; color: #334155; margin: 16px 0 6px; border-left: 4px solid #4f46e5; padding-left: 8px; }
    .text-muted { color: #94a3b8; }
    .pass { color: #16a34a; } .fail { color: #dc2626; }
    .footer { text-align: center; font-size: 10px; color: #94a3b8; margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 10px; }
</style>
</head>
<body>
<div class="header">
    <h1>{{ $student->name }}</h1>
    <p>
        <span class="badge">{{ $student->student_number ?? 'N/A' }}</span>
        &nbsp;
        <span class="badge">{{ $student->course }}</span>
        &nbsp;
        <span class="badge">{{ $student->year_level }}</span>
        &nbsp;
        <span class="badge">{{ $student->status }}</span>
    </p>
    <p>Email: {{ $student->email }} &nbsp;|&nbsp; Age: {{ $student->age }} &nbsp;|&nbsp; GPA: {{ $student->gpa ? number_format($student->gpa, 2) : 'N/A' }}</p>
</div>

<div class="info-grid">
    <div class="info-card">
        <div class="value" style="color: #16a34a;">{{ $presentCount }}</div>
        <div class="label">Days Present</div>
    </div>
    <div class="info-card">
        <div class="value" style="color: #dc2626;">{{ $absentCount }}</div>
        <div class="label">Days Absent</div>
    </div>
    <div class="info-card">
        <div class="value" style="color: #d97706;">{{ $lateCount }}</div>
        <div class="label">Days Late</div>
    </div>
</div>

<div class="section-title">Academic Grades</div>
@if($grades->count() > 0)
<table>
    <thead>
        <tr>
            <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Semester</th>
            <th>Grade</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach($grades as $grade)
        <tr>
            <td>{{ $grade->subject->code }}</td>
            <td>{{ $grade->subject->name }}</td>
            <td>{{ $grade->semester->label ?? 'N/A' }}</td>
            <td><strong>{{ $grade->grade ?? 'N/A' }}</strong></td>
            <td class="{{ $grade->remarks === 'Passed' ? 'pass' : ($grade->remarks === 'Failed' ? 'fail' : '') }}">{{ $grade->remarks ?? 'Pending' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p class="text-muted">No grade records available.</p>
@endif

<div class="section-title">Enrollment Records</div>
@if($enrollments->count() > 0)
<table>
    <thead>
        <tr>
            <th>Semester</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($enrollments as $enrollment)
        <tr>
            <td>{{ $enrollment->semester->label ?? 'N/A' }}</td>
            <td>{{ $enrollment->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p class="text-muted">No enrollment records available.</p>
@endif

<div class="section-title">Attendance Log (Last {{ min(30, $attendances->count()) }} records)</div>
@if($attendances->count() > 0)
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Status</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances->take(30) as $att)
        <tr>
            <td>{{ $att->date->format('F d, Y') }}</td>
            <td class="{{ $att->status === 'Present' ? 'pass' : ($att->status === 'Absent' ? 'fail' : '') }}">{{ $att->status }}</td>
            <td class="text-muted">{{ $att->notes ?? '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p class="text-muted">No attendance records available.</p>
@endif

<div class="footer">
    Generated on {{ now()->format('F d, Y \a\t h:i A') }} &mdash; Student Management System
</div>
</body>
</html>
