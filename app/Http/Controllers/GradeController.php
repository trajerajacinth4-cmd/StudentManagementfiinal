<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $selectedStudent = $request->query('student_id');
        $selectedSemester = $request->query('semester_id');

        $query = Grade::with(['student', 'subject', 'semester']);

        if ($selectedStudent) {
            $query->where('student_id', $selectedStudent);
        }
        if ($selectedSemester) {
            $query->where('semester_id', $selectedSemester);
        }

        $grades = $query->latest()->paginate(20);
        $students = Student::orderBy('last_name')->get();
        $semesters = Semester::orderByDesc('id')->get();

        return view('grades.index', compact('grades', 'students', 'semesters', 'selectedStudent', 'selectedSemester'));
    }

    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        $subjects = Subject::orderBy('code')->get();
        $semesters = Semester::orderByDesc('id')->get();
        $activeSemester = Semester::active();
        $remarks = Grade::$remarks;

        return view('grades.create', compact('students', 'subjects', 'semesters', 'activeSemester', 'remarks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'  => 'required|exists:students,id',
            'subject_id'  => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'grade'       => 'nullable|numeric|min:1.00|max:5.00',
            'remarks'     => 'nullable|in:' . implode(',', Grade::$remarks),
        ]);

        $grade = Grade::updateOrCreate(
            [
                'student_id'  => $validated['student_id'],
                'subject_id'  => $validated['subject_id'],
                'semester_id' => $validated['semester_id'],
            ],
            [
                'grade'   => $validated['grade'],
                'remarks' => $validated['remarks'],
            ]
        );

        $student = Student::find($validated['student_id']);
        $subject = Subject::find($validated['subject_id']);

        ActivityLog::log('GRADE_ENTRY', "Entered grade {$validated['grade']} for {$student->name} in {$subject->code}.");

        return redirect()->route('grades.index')->with('success', "Grade saved for {$student->name}.");
    }

    public function edit(Grade $grade)
    {
        $students = Student::orderBy('last_name')->get();
        $subjects = Subject::orderBy('code')->get();
        $semesters = Semester::orderByDesc('id')->get();
        $remarks = Grade::$remarks;

        return view('grades.edit', compact('grade', 'students', 'subjects', 'semesters', 'remarks'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'grade'   => 'nullable|numeric|min:1.00|max:5.00',
            'remarks' => 'nullable|in:' . implode(',', Grade::$remarks),
        ]);

        $grade->update($validated);
        ActivityLog::log('UPDATE_GRADE', "Updated grade for {$grade->student->name} in {$grade->subject->code}.");

        return redirect()->route('grades.index')->with('success', "Grade updated for {$grade->student->name}.");
    }

    public function destroy(Grade $grade)
    {
        $name = $grade->student->name;
        $grade->delete();

        return redirect()->route('grades.index')->with('success', "Grade deleted for {$name}.");
    }
}
