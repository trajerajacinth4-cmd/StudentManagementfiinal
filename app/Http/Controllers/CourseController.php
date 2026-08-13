<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of managed courses.
     */
    public function index(Request $request)
    {
        $courses = Course::latest()->get();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data'    => $courses,
                'count'   => $courses->count()
            ]);
        }

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->validated());

        ActivityLog::log('CREATE_COURSE', "Created course '{$course->code} - {$course->name}'.");

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Course '{$course->code}' created successfully.",
                'data'    => $course
            ], 201);
        }

        return redirect()->route('courses.index')->with('success', "Course '{$course->code}' created successfully.");
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course, Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data'    => $course
            ]);
        }

        return response()->json($course);
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        ActivityLog::log('UPDATE_COURSE', "Updated course '{$course->code}'.");

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Course '{$course->code}' updated successfully.",
                'data'    => $course
            ]);
        }

        return redirect()->route('courses.index')->with('success', "Course '{$course->code}' updated successfully.");
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Request $request, Course $course)
    {
        $code = $course->code;
        $id   = $course->id;
        $course->delete();

        ActivityLog::log('DELETE_COURSE', "Deleted course '{$code}'.");

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Course '{$code}' deleted successfully.",
                'id'      => $id
            ]);
        }

        return redirect()->route('courses.index')->with('success', "Course '{$code}' deleted successfully.");
    }
}
