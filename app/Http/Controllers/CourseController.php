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
    public function index()
    {
        $courses = Course::latest()->paginate(10);

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

        return redirect()->route('courses.index')->with('success', "Course '{$course->code}' created successfully.");
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

        return redirect()->route('courses.index')->with('success', "Course '{$course->code}' updated successfully.");
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        $code = $course->code;
        $course->delete();

        ActivityLog::log('DELETE_COURSE', "Deleted course '{$code}'.");

        return redirect()->route('courses.index')->with('success', "Course '{$code}' deleted successfully.");
    }
}
