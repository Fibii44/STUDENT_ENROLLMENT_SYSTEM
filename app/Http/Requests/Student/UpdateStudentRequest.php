<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStudentRequest extends FormRequest
{
    public function authorize()
    {
        // Check if user is admin
        return Auth::user() && Auth::user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:students,email,' . $this->student->id],
            'age' => ['required', 'integer', 'min:16', 'max:100'],
            'year' => ['required', 'in:1,2,3,4'],
            'course' => ['required', 'in:BSIT,BSCS,BSIS'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'age.required' => 'Age is required',
            'age.min' => 'Student must be at least 16 years old',
            'age.max' => 'Student age cannot exceed 100 years',
            'year.required' => 'Year level is required',
            'year.in' => 'Please select a valid year level',
            'course.required' => 'Course is required',
            'course.in' => 'Please select a valid course',
            'address.required' => 'Address is required',
        ];
    }
}