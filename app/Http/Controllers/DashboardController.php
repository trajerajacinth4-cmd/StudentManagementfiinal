<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Semester;

class DashboardController extends Controller
{
    public function index()
    {
        // Student totals
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'Active')->count();
        $graduatedStudents = Student::where('status', 'Graduated')->count();
        $droppedStudents = Student::where('status', 'Dropped')->count();

        // Students per year level
        $yearLevelData = Student::selectRaw('year_level, COUNT(*) as count')
            ->groupBy('year_level')
            ->orderBy('year_level')
            ->pluck('count', 'year_level');

        // Students per course
        $courseData = Student::selectRaw('course, COUNT(*) as count')
            ->groupBy('course')
            ->orderByDesc('count')
            ->pluck('count', 'course');

        // Students per status
        $statusData = Student::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Average GPA
        $averageGpa = Student::whereNotNull('gpa')->avg('gpa');

        // Top 5 students by GPA (honor roll preview)
        $topStudents = Student::whereNotNull('gpa')
            ->where('status', 'Active')
            ->orderByDesc('gpa')
            ->limit(5)
            ->get();

        // Recent activity — last 5 added students
        $recentStudents = Student::latest()->limit(5)->get();

        // Total courses
        $totalCourses = Course::count();

        // Active semester
        $activeSemester = Semester::active();

        // Attendance overview for today
        $today = now()->toDateString();
        $todayPresent = Attendance::where('date', $today)->where('status', 'Present')->count();
        $todayAbsent = Attendance::where('date', $today)->where('status', 'Absent')->count();
        $todayLate = Attendance::where('date', $today)->where('status', 'Late')->count();

        // All students for client-side filtering (year-level interactive filter)
        $allStudents = Student::orderBy('created_at', 'desc')
            ->get()
            ->map(fn($s) => [
                'id'             => $s->id,
                'name'           => $s->name,
                'student_number' => $s->student_number,
                'course'         => $s->course ?? '—',
                'year_level'     => $s->year_level ?? '—',
                'status'         => $s->status,
                'gpa'            => $s->gpa,
                'avatar_url'     => $s->avatar_url,
                'created_at'     => $s->created_at,
            ]);

        // Courses list for filter dropdown / buttons
        $coursesList = Student::whereNotNull('course')
            ->where('course', '!=', '')
            ->distinct()
            ->pluck('course')
            ->sort()
            ->values();

        return view('dashboard.index', compact(
            'totalStudents', 'activeStudents', 'graduatedStudents', 'droppedStudents',
            'yearLevelData', 'courseData', 'statusData',
            'averageGpa', 'topStudents', 'recentStudents',
            'totalCourses', 'activeSemester',
            'todayPresent', 'todayAbsent', 'todayLate',
            'allStudents', 'coursesList'
        ));
    }
}


