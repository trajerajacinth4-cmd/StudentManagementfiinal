<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->paginate(15);
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:20|unique:subjects,code',
            'name'        => 'required|string|max:255',
            'units'       => 'required|numeric|min:0.5|max:9',
            'description' => 'nullable|string|max:1000',
        ]);

        $subject = Subject::create($validated);
        ActivityLog::log('CREATE_SUBJECT', "Created subject '{$subject->code} - {$subject->name}'.");

        return redirect()->route('subjects.index')->with('success', "Subject '{$subject->code}' created successfully.");
    }

    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'name'        => 'required|string|max:255',
            'units'       => 'required|numeric|min:0.5|max:9',
            'description' => 'nullable|string|max:1000',
        ]);

        $subject->update($validated);
        ActivityLog::log('UPDATE_SUBJECT', "Updated subject '{$subject->code}'.");

        return redirect()->route('subjects.index')->with('success', "Subject '{$subject->code}' updated successfully.");
    }

    public function destroy(Subject $subject)
    {
        $code = $subject->code;
        $subject->delete();
        ActivityLog::log('DELETE_SUBJECT', "Deleted subject '{$code}'.");

        return redirect()->route('subjects.index')->with('success', "Subject '{$code}' deleted.");
    }
}
