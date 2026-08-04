<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\StudentController;
use App\Models\Student;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $studentId = $this->route('student')->id ?? $this->route('student');

        return [
            'student_number' => 'nullable|string|max:50|unique:students,student_number,' . $studentId,
            'first_name'     => 'required|string|max:255',
            'middle_name'    => 'nullable|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:students,email,' . $studentId,
            'course'         => 'required|string|max:255',
            'year_level'     => 'required|string|in:' . implode(',', StudentController::$yearLevels),
            'status'         => 'required|string|in:' . implode(',', Student::$statuses),
            'gpa'            => 'nullable|numeric|min:0.00|max:5.00',
            'avatar'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'age'            => 'required|integer|min:1|max:120',
        ];
    }
}
