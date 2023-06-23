<?php

namespace App\Http\Controllers;

use App\Models\StudentGrades;
use App\Http\Requests\StudentGradeStoreRequest;
use App\Http\Requests\StudentGradeUpdateRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\StudentGradeResource;

class StudentGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $StudentGrade = StudentGrades::all();
        return StudentGradeResource::collection($StudentGrade);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentGradeStoreRequest $request): StudentGradeResource
    {
        $validated = $request->validated();

        return new StudentGradeResource(StudentGrades::create($validated));
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentGradeUpdateRequest $request, StudentGrades $studentGrade): StudentGradeResource|JsonResponse
    {
        $validated = $request->validated();
        if (empty($validated)) {
            return response()->json(['message' => 'Not modified'], 304);
        }

        $studentGrade->update($validated);
        return new StudentGradeResource($studentGrade);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentGrades $studentGrade): JsonResponse
    {
        $studentGrade->delete();
        return response()->json(['message' => 'Resource deleted']);
    }
}
