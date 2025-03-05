<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize()
    {
        // Allow only admin users to enroll students
        return Auth::user() && Auth::user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|in:First,Second,Summer',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $student = Student::find($this->student_id);
            $subject = Subject::find($this->subject_id);

            // Validate if the subject matches the student's year level
            if ($student && $subject && $student->year != $subject->year) {
                $validator->errors()->add('subject_id', 'The selected subject does not match the student\'s year level.');
            }

            // Check if the student is already enrolled in this subject
            if (Enrollment::where('student_id', $this->student_id)
                ->where('subject_id', $this->subject_id)
                ->where('semester', $this->semester)
                ->exists()) 
            {
                $validator->errors()->add('subject_id', 'This student is already enrolled in this subject.');
            }
        });
    }
}
