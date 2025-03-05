<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Http\Requests\Student\StoreEnrollmentRequest;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display the student's enrollment page.
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        
        // Fetch subjects that match the student's year level
        $availableSubjects = Subject::where('year', $student->year)->get();

        // Fetch student enrollments with related subjects and grades
        $enrollments = Enrollment::with('subject', 'grades')
            ->where('student_id', $id)
            ->get();

        return view('student_info', compact('student', 'availableSubjects', 'enrollments'));
    }

    /**
     * Store a new enrollment.
     */
    public function store(StoreEnrollmentRequest $request)
    {
        $validated = $request->validated();

        // Create enrollment record
        $enrollment = Enrollment::create([
            'student_id' => $validated['student_id'],
            'subject_id' => $validated['subject_id'],
            'semester' => $validated['semester'],
            'status' => 'enrolled'
        ]);

        // Create default grade entry
        Grade::create([
            'student_id' => $validated['student_id'],
            'enrollment_id' => $enrollment->id,
            'grade' => 'Not Yet Graded',
        ]);

        return redirect()->back()->with('success', 'Subject enrollment created successfully');
    }

    /**
     * Update an enrollment.
     */
    public function update(StoreEnrollmentRequest $request, Enrollment $enrollment)
    {
        $validated = $request->validated();

        $enrollment->update([
            'subject_id' => $validated['subject_id'],
            'semester' => $validated['semester'],
            'status' => 'enrolled',
        ]);

        return redirect()->back()->with('success', 'Enrollment updated successfully');
    }

    /**
     * Delete an enrollment.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->back()->with('success', 'Enrollment deleted successfully');
    }
}
