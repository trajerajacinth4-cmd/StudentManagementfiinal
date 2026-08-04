<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Standard Year Levels available in the system.
     */
    public static array $yearLevels = ['1st Year', '2nd Year', '3rd Year', '4th Year'];

    /**
     * Download Student list as PDF (filtered by year level, status, or search).
     */
    public function downloadPdf(Request $request)
    {
        $query = Student::query();
        $selectedYearLevel = $request->query('year_level');

        if ($selectedYearLevel && in_array($selectedYearLevel, self::$yearLevels)) {
            $query->where('year_level', $selectedYearLevel);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('course', 'like', "%{$search}%")
                  ->orWhere('student_number', 'like', "%{$search}%");
            });
        }

        $students = $query->get();
        $pdf = Pdf::loadView('students.pdf', [
            'students'          => $students,
            'selectedYearLevel' => $selectedYearLevel,
        ]);

        $filename = $selectedYearLevel 
            ? 'students_' . strtolower(str_replace(' ', '_', $selectedYearLevel)) . '.pdf'
            : 'student_list.pdf';

        ActivityLog::log('PDF_DOWNLOAD', "Downloaded PDF report containing " . count($students) . " student records.");

        return $pdf->download($filename);
    }

    /**
     * Export students list to CSV file.
     */
    public function exportCsv(Request $request)
    {
        $query = Student::query();

        if ($year = $request->query('year_level')) {
            if (in_array($year, self::$yearLevels)) {
                $query->where('year_level', $year);
            }
        }

        if ($status = $request->query('status')) {
            if (in_array($status, Student::$statuses)) {
                $query->where('status', $status);
            }
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('course', 'like', "%{$search}%")
                  ->orWhere('student_number', 'like', "%{$search}%");
            });
        }

        $students = $query->get();

        $filename = "students_export_" . date('Y_m_d_His') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Student Number', 'First Name', 'Middle Name', 'Last Name', 'Full Name', 'Email', 'Course', 'Year Level', 'Status', 'GPA', 'Age', 'Created At']);

            foreach ($students as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->student_number,
                    $row->first_name,
                    $row->middle_name,
                    $row->last_name,
                    $row->name,
                    $row->email,
                    $row->course,
                    $row->year_level,
                    $row->status,
                    $row->gpa,
                    $row->age,
                    $row->created_at ? $row->created_at->format('Y-m-d H:i') : ''
                ]);
            }

            fclose($file);
        };

        ActivityLog::log('CSV_EXPORT', "Exported " . count($students) . " student records to CSV.");

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import students from uploaded CSV file.
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:4096',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $records = array_map('str_getcsv', file($path));

        if (count($records) < 2) {
            return back()->with('error', 'CSV file is empty or missing headers.');
        }

        $header = array_shift($records);
        $importedCount = 0;

        foreach ($records as $row) {
            if (count($row) < 3) continue;

            $firstName  = trim($row[0] ?? '');
            $middleName = trim($row[1] ?? '');
            $lastName   = trim($row[2] ?? '');
            $email      = trim($row[3] ?? '');
            $course     = trim($row[4] ?? 'BSCS');
            $year_level = trim($row[5] ?? '1st Year');
            $status     = trim($row[6] ?? 'Active');
            $age        = intval($row[7] ?? 20);

            if (empty($firstName) || empty($lastName) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            if (!in_array($year_level, self::$yearLevels)) {
                $year_level = '1st Year';
            }

            if (!in_array($status, Student::$statuses)) {
                $status = 'Active';
            }

            $studentNumber = 'STD-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

            Student::updateOrCreate(
                ['email' => $email],
                [
                    'student_number' => $studentNumber,
                    'first_name'     => $firstName,
                    'middle_name'    => $middleName,
                    'last_name'      => $lastName,
                    'course'         => $course,
                    'year_level'     => $year_level,
                    'status'         => $status,
                    'age'            => $age > 0 ? $age : 20,
                ]
            );
            $importedCount++;
        }

        ActivityLog::log('CSV_IMPORT', "Imported/updated {$importedCount} student records via CSV upload.");

        return redirect()->route('students.index')->with('success', "Successfully imported {$importedCount} student records.");
    }

    /**
     * Display listing of students with live search, multi-filters, and sorting.
     */
    public function index(Request $request)
    {
        $selectedYearLevel = $request->query('year_level');
        $selectedStatus    = $request->query('status');
        $selectedCourse    = $request->query('course');
        $search            = $request->query('search');
        $sortBy            = $request->query('sort_by', 'created_at');
        $sortDir           = $request->query('sort_dir', 'desc');

        $query = Student::query();

        if ($selectedYearLevel && in_array($selectedYearLevel, self::$yearLevels)) {
            $query->where('year_level', $selectedYearLevel);
        }

        if ($selectedStatus && in_array($selectedStatus, Student::$statuses)) {
            $query->where('status', $selectedStatus);
        }

        if ($selectedCourse) {
            $query->where('course', $selectedCourse);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('course', 'like', "%{$search}%")
                  ->orWhere('student_number', 'like', "%{$search}%");
            });
        }

        $allowedSorts = ['first_name', 'last_name', 'email', 'course', 'year_level', 'status', 'gpa', 'age', 'student_number', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, strtolower($sortDir) === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        $students = $query->paginate(10)->withQueryString();

        $totalStudents = Student::count();
        $yearCounts = [
            'All' => $totalStudents,
        ];

        foreach (self::$yearLevels as $year) {
            $yearCounts[$year] = Student::where('year_level', $year)->count();
        }

        // Fetch managed courses from Courses table
        $managedCourses = Course::orderBy('code')->get();

        return view('students.index', [
            'students'          => $students,
            'yearLevels'        => self::$yearLevels,
            'statuses'          => Student::$statuses,
            'managedCourses'    => $managedCourses,
            'selectedYearLevel' => $selectedYearLevel,
            'selectedStatus'    => $selectedStatus,
            'selectedCourse'    => $selectedCourse,
            'search'            => $search,
            'sortBy'            => $sortBy,
            'sortDir'           => $sortDir,
            'yearCounts'        => $yearCounts,
        ]);
    }

    /**
     * Show form for creating a student.
     */
    public function create()
    {
        $courses = Course::orderBy('code')->get();

        return view('students.create', [
            'yearLevels' => self::$yearLevels,
            'statuses'   => Student::$statuses,
            'courses'    => $courses,
        ]);
    }

    /**
     * Store newly created student with avatar upload and student number generation.
     */
    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();

        if (empty($validated['student_number'])) {
            $validated['student_number'] = 'STD-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $student = Student::create($validated);

        ActivityLog::log('CREATE_STUDENT', "Created student record for {$student->name} ({$student->student_number}).");

        return redirect()->route('students.index')->with('success', "Student '{$student->name}' created successfully.");
    }

    /**
     * Display student details.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show form for editing student.
     */
    public function edit(Student $student)
    {
        $courses = Course::orderBy('code')->get();

        return view('students.edit', [
            'student'    => $student,
            'yearLevels' => self::$yearLevels,
            'statuses'   => Student::$statuses,
            'courses'    => $courses,
        ]);
    }

    /**
     * Update student details with optional avatar upload.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($student->avatar && Storage::disk('public')->exists($student->avatar)) {
                Storage::disk('public')->delete($student->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $student->update($validated);

        ActivityLog::log('UPDATE_STUDENT', "Updated student details for {$student->name} ({$student->student_number}).");

        return redirect()->route('students.index')->with('success', "Student '{$student->name}' updated successfully.");
    }

    /**
     * Delete student record.
     */
    public function destroy(Student $student)
    {
        $name = $student->name;
        $num = $student->student_number;

        if ($student->avatar && Storage::disk('public')->exists($student->avatar)) {
            Storage::disk('public')->delete($student->avatar);
        }

        $student->delete();

        ActivityLog::log('DELETE_STUDENT', "Deleted student record for {$name} ({$num}).");

        return redirect()->route('students.index')->with('success', "Student '{$name}' deleted successfully.");
    }

    /**
     * Bulk Delete selected students.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_students', []);

        if (empty($ids)) {
            return back()->with('error', 'No students selected for bulk deletion.');
        }

        $students = Student::whereIn('id', $ids)->get();
        $count = $students->count();

        foreach ($students as $st) {
            if ($st->avatar && Storage::disk('public')->exists($st->avatar)) {
                Storage::disk('public')->delete($st->avatar);
            }
            $st->delete();
        }

        ActivityLog::log('BULK_DELETE', "Bulk deleted {$count} student records.");

        return redirect()->route('students.index')->with('success', "Successfully deleted {$count} selected students.");
    }

    /**
     * Bulk Academic Promotion.
     */
    public function bulkPromote(Request $request)
    {
        $ids = $request->input('selected_students', []);

        if (empty($ids)) {
            return back()->with('error', 'No students selected for promotion.');
        }

        $students = Student::whereIn('id', $ids)->get();
        $promotedCount = 0;

        foreach ($students as $st) {
            if ($st->year_level === '1st Year') {
                $st->update(['year_level' => '2nd Year']);
            } elseif ($st->year_level === '2nd Year') {
                $st->update(['year_level' => '3rd Year']);
            } elseif ($st->year_level === '3rd Year') {
                $st->update(['year_level' => '4th Year']);
            } elseif ($st->year_level === '4th Year') {
                $st->update(['status' => 'Graduated']);
            }
            $promotedCount++;
        }

        ActivityLog::log('BULK_PROMOTE', "Promoted academic standing for {$promotedCount} students.");

        return redirect()->route('students.index')->with('success', "Successfully promoted {$promotedCount} students.");
    }
}
