<?php

namespace App\Http\Requests\Subject;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Check if user is admin
        return Auth::user() && Auth::user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'subject_code' => ['required', 'unique:subjects,subject_code,' . $this->subject->id],
            'subject_name' => ['required', 'string', 'max:255'],
            'course' => ['required', 'in:BSIT,BSCS,BSIS'],
            'year' => ['required', 'in:1,2,3,4'],
            
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'subject_code.required' => 'Subject code is required',
            'subject_code.unique' => 'This subject code is already taken',
            'subject_name.required' => 'Subject name is required',
            'course.required' => 'Course is required',
            'course.in' => 'Please select a valid course',
        ];
    }
}