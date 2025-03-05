<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display dashboard statistics.
     */
    public function index()
    {
        $totalStudents = Student::count();
        $totalEnrollments = Enrollment::count();
        $totalSubjects = Subject::count();

        return view('dashboard', compact('totalStudents', 'totalEnrollments', 'totalSubjects'));
    }
}