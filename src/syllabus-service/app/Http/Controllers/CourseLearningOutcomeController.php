<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseLearningOutcomesRequest;
use App\Http\Requests\UpdateCourseLearningOutcomesRequest;
use App\Http\Resources\CourseLearningOutcomeCollection;
use App\Http\Resources\CourselearningOutcomeResource;
use App\Models\CourseLearningOutcome;
use App\Models\Syllabus;


class CourseLearningOutcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): CourseLearningOutcomeCollection
    {
        $clo = CourseLearningOutcome::latest()->paginate(10);
        return new CourseLearningOutcomeCollection($clo->appends(request()->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseLearningOutcomesRequest $request, Syllabus $syllabus)
    {
        $validated = $request->validated();
        $newPosition = $syllabus->courseLearningOutcomes()->max('position') + 1;
        $validated['position'] = $newPosition;
        return new CourseLearningOutcomeResource($syllabus->courseLearningOutcomes()->create($validate));
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseLearningOutcome $clo): CourselearningOutcomeResource
    {
        return new CourseLearningOutcomeResource($clo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseLearningOutcomesRequest $request, CourseLearningOutcome $clo): CourseLearningOutcomeResource|JsonResponse
    {
        $validated = $request->validated();
        if (empty($validated)) {
            return response()->json(['message' => 'Not modified'], 304);
        }
        $clo->update($validated);
        return new CourseLearningOutcomeResource($clo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseLearningOutcome $clo)
    {
        $clo->delete();
        return response()->json([
            'message' => 'Resource deleted'
        ]);
    }
}
