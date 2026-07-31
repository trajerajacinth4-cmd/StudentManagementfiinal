<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        Student::create($request->all());

        return redirect('/students/create')
            ->with('success', 'Student Added!');
    }
}