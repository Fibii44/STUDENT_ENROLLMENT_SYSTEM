<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateGradeRequest extends FormRequest
{
    public function authorize()
    {
        // Check if user is admin
        return Auth::user() && Auth::user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'grade' => 'required|in:1.00,1.25,1.50,1.75,2.00,2.25,2.50,2.75,3.00,5.00',
        ];
    }

    public function messages()
    {
        return [
            'grade.required' => 'A grade is required.',
            'grade.in' => 'The grade must be one of the standard values.',
        ];
    }
}