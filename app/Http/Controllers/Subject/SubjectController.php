<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\Subject\StoreSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Requests\Subject\SearchSubjectRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Add Request parameter
{
    $search = $request->input('search'); // Get search query

    // Fetch subjects with search functionality
    $subjects = Subject::when($search, function ($query, $search) {
        return $query->where('subject_name', 'LIKE', "%{$search}%")
                     ->orWhere('subject_code', 'LIKE', "%{$search}%")
                     ->orWhere('course', 'LIKE', "%{$search}%");
    })->paginate(10);

    return view('subject.subjects', compact('subjects', 'search'));
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
    public function store(StoreSubjectRequest $request)
    {
        $validated = $request->validated();
        
        Subject::create($validated);

        return redirect()->route('subjects')
            ->with('success', 'Subject created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return response()->json($subject);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return response()->json($subject);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $validated = $request->validated();
        $subject->update($validated);

        return redirect()->route('subjects')
            ->with('success', 'Subject updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects')
            ->with('success', 'Subject deleted successfully!');
    }
}
