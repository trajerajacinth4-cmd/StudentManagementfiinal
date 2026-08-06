<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $selectedSemester = $request->query('semester_id');
        $query = Enrollment::with(['student', 'semester', 'subjects']);

        if ($selectedSemester) {
            $query->where('semester_id', $selectedSemester);
        }

        $enrollments = $query->latest()->paginate(15);
        $semesters = Semester::orderByDesc('id')->get();

        return view('enrollments.index', compact('enrollments', 'semesters', 'selectedSemester'));
    }

    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        $semesters = Semester::orderByDesc('id')->get();
        $subjects = Subject::orderBy('code')->get();
        $activeSemester = Semester::active();

        return view('enrollments.create', compact('students', 'semesters', 'subjects', 'activeSemester'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,id',
            'semester_id' => 'required|exists:semesters,id',
            'status'      => 'required|in:' . implode(',', Enrollment::$statuses),
            'notes'       => 'nullable|string|max:500',
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $enrollment = Enrollment::updateOrCreate(
            ['student_id' => $validated['student_id'], 'semester_id' => $validated['semester_id']],
            ['status' => $validated['status'], 'notes' => $validated['notes'] ?? null]
        );

        if (!empty($validated['subject_ids'])) {
            $enrollment->subjects()->sync($validated['subject_ids']);
        }

        $student = Student::find($validated['student_id']);
        $semester = Semester::find($validated['semester_id']);

        ActivityLog::log('ENROLL_STUDENT', "Enrolled {$student->name} for {$semester->label}.");

        return redirect()->route('enrollments.index')->with('success', "{$student->name} enrolled successfully.");
    }

    public function destroy(Enrollment $enrollment)
    {
        $name = $enrollment->student->name;
        $label = $enrollment->semester->label;
        $enrollment->delete();

        ActivityLog::log('DROP_ENROLLMENT', "Dropped enrollment of {$name} from {$label}.");

        return redirect()->route('enrollments.index')->with('success', "Enrollment for {$name} dropped.");
    }
}
