<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
        $courseId = $this->route('course')->id ?? $this->route('course');

        return [
            'code'        => 'required|string|max:20|unique:courses,code,' . $courseId,
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }
}
