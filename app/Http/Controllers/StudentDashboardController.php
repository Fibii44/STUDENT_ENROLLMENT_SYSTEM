<?php

namespace App\Http\Controllers;


use App\Models\Student;
use App\Models\Grade;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $student = Student::where('email', $user->email)->first();
    
        if (!$student) {
            abort(404, 'Student record not found.');
        }
    
        $grades = Grade::with(['enrollment.subject'])
            ->where('student_id', $student->id)
            ->get();
    
        return view('dashboardStudent', compact('student', 'grades'));
    }
}