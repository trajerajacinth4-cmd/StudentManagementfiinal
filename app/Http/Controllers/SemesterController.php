<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::latest()->paginate(15);
        return view('semesters.index', compact('semesters'));
    }

    public function create()
    {
        $semesterNames = Semester::$semesterNames;
        return view('semesters.create', compact('semesterNames'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|in:' . implode(',', Semester::$semesterNames),
            'school_year' => 'required|string|max:20',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($validated['is_active']) {
            Semester::where('is_active', true)->update(['is_active' => false]);
        }

        $semester = Semester::create($validated);
        ActivityLog::log('CREATE_SEMESTER', "Created semester '{$semester->label}'.");

        return redirect()->route('semesters.index')->with('success', "Semester '{$semester->label}' created successfully.");
    }

    public function edit(Semester $semester)
    {
        $semesterNames = Semester::$semesterNames;
        return view('semesters.edit', compact('semester', 'semesterNames'));
    }

    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'name'        => 'required|string|in:' . implode(',', Semester::$semesterNames),
            'school_year' => 'required|string|max:20',
            'is_active'   => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($validated['is_active']) {
            Semester::where('is_active', true)->where('id', '!=', $semester->id)->update(['is_active' => false]);
        }

        $semester->update($validated);
        ActivityLog::log('UPDATE_SEMESTER', "Updated semester '{$semester->label}'.");

        return redirect()->route('semesters.index')->with('success', "Semester '{$semester->label}' updated.");
    }

    public function destroy(Semester $semester)
    {
        $label = $semester->label;
        $semester->delete();
        ActivityLog::log('DELETE_SEMESTER', "Deleted semester '{$label}'.");

        return redirect()->route('semesters.index')->with('success', "Semester '{$label}' deleted.");
    }

    public function setActive(Semester $semester)
    {
        $semester->activate();
        ActivityLog::log('ACTIVATE_SEMESTER', "Set '{$semester->label}' as the active semester.");

        return redirect()->route('semesters.index')->with('success', "'{$semester->label}' is now the active semester.");
    }
}
