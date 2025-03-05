<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Enrollment;
use App\Http\Requests\Student\StoreGradeRequest;
use App\Http\Requests\Student\UpdateGradeRequest;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $students = Student::with('enrollments.subject')->get();
    return view('grades', compact('students'));
}

    public function getStudentGrades($studentId)
    {
        $enrollments = Enrollment::with(['subject', 'grade'])
            ->where('student_id', $studentId)
            ->get();
            
        return response()->json($enrollments);
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
    public function store(StoreGradeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGradeRequest $request, $enrollmentId)
{
    $grade = Grade::where('enrollment_id', $enrollmentId)->first();

    if (!$grade) {
        return redirect()->back()->with('error', 'Grade record not found.');
    }

    try {
        $grade->update(['grade' => $request->grade]);
        return redirect()->back()->with('success', 'Grade updated successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update grade. Please try again.');
    }
}

    /**
     * Remove the specified resource from storage.
     */
    /**
 * Remove the specified resource from storage.
 */
public function destroy(Grade $grade)
{
    DB::beginTransaction();
    try {
        // Find the associated enrollment
        $enrollment = Enrollment::find($grade->enrollment_id);
        
        // Delete the grade first since it references the enrollment
        $grade->delete();
        
        // Delete the enrollment if it exists
        if ($enrollment) {
            $enrollment->delete();
        }

        DB::commit();
        return redirect()->back()->with('success', 'Grade and enrollment deleted successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Grade deletion failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to delete grade and enrollment');
    }
}
}
