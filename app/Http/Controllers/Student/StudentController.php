<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Enrollment;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\Student\SearchStudentRequest;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //For student table
    public function index(SearchStudentRequest $request)
    {
        $search = $request->validated('search');

        $students = Student::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('id', 'LIKE', "%{$search}%")
                        ->orWhere('course', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
        })->paginate(10);

        foreach ($students as $student) {
            $student->has_account = \DB::table('users')->where('email', $student->email)->exists();
        }

        return view('student.students', compact('students', 'search'));
    }
    
    
    //For student dashboard
    public function studentDashboard()
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



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();
        Student::create($validated);
        
        return redirect()->back()
        ->with('success', 'Student added successfully');
}
    


    //For individual student subjects and grades
    public function showStudentGrades($studentId)
{
    $student = Student::findOrFail($studentId);

    // Get the subject IDs that the student is already enrolled in
    $enrolledSubjectIds = Enrollment::where('student_id', $studentId)->pluck('subject_id')->toArray();

    // Get only subjects that the student is NOT enrolled in
    $availableSubjects = Subject::whereNotIn('id', $enrolledSubjectIds)->get();

    // Get the student's enrollments with subjects and grades
    $enrollments = Enrollment::with(['subject', 'grades'])->where('student_id', $studentId)->get();

    // Check and create missing grades
    foreach ($enrollments as $enrollment) {
        if ($enrollment->grades->isEmpty()) {
            $enrollment->grades()->create([
                'student_id' => $studentId, // Ensure student_id is included
                'enrollment_id' => $enrollment->id,
                'grade' => 'Not Yet Graded', // Default grade
            ]);
        }
    }

    return view('student.studentInfo', compact('student', 'enrollments', 'availableSubjects'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validated = $request->validated();
        $student->update($validated);
        
        return redirect()->back()
        ->with('success', 'Student updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->back()
        ->with('success', 'Student deleted successfully');
    }
}
