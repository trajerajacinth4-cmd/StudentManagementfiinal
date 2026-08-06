<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->query('date', now()->toDateString());
        $selectedStudent = $request->query('student_id');

        $query = Attendance::with('student')->where('date', $selectedDate);

        if ($selectedStudent) {
            $query->where('student_id', $selectedStudent);
        }

        $attendances = $query->paginate(20);
        $students = Student::orderBy('last_name')->get();

        $presentCount = Attendance::where('date', $selectedDate)->where('status', 'Present')->count();
        $absentCount  = Attendance::where('date', $selectedDate)->where('status', 'Absent')->count();
        $lateCount    = Attendance::where('date', $selectedDate)->where('status', 'Late')->count();

        return view('attendance.index', compact(
            'attendances', 'students', 'selectedDate', 'selectedStudent',
            'presentCount', 'absentCount', 'lateCount'
        ));
    }

    public function create()
    {
        $students = Student::where('status', 'Active')->orderBy('last_name')->get();
        $statuses = Attendance::$statuses;
        $today = now()->toDateString();

        return view('attendance.create', compact('students', 'statuses', 'today'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'     => 'required|date',
            'records'  => 'required|array',
            'records.*.student_id' => 'required|exists:students,id',
            'records.*.status'     => 'required|in:' . implode(',', Attendance::$statuses),
            'records.*.notes'      => 'nullable|string|max:255',
        ]);

        $count = 0;
        foreach ($validated['records'] as $record) {
            Attendance::updateOrCreate(
                ['student_id' => $record['student_id'], 'date' => $validated['date']],
                ['status' => $record['status'], 'notes' => $record['notes'] ?? null]
            );
            $count++;
        }

        ActivityLog::log('ATTENDANCE_LOG', "Logged attendance for {$count} students on {$validated['date']}.");

        return redirect()->route('attendance.index', ['date' => $validated['date']])->with('success', "Attendance logged for {$count} students.");
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', Attendance::$statuses),
            'notes'  => 'nullable|string|max:255',
        ]);

        $attendance->update($validated);

        return back()->with('success', "Attendance updated.");
    }
}
