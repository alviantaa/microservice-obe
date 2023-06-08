<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Models\IntendedLearningOutcome;
use App\Http\Requests\StoreIntendedLearningOutcomeRequest;
use App\Http\Requests\UpdateIntendedLearningOutcomesRequest;
use App\Http\Resources\IntendedLearningOutcomeResource;


class IntendedLearningOutcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IntendedLearningOutcome $ilo)
    {
        $ilo = CourseLearningOutcome::latest()->paginate(10);
        return new IntendedLearningOutcomeCollection($ilo->appends(request()->query()));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIntendedLearningOutcomeRequest $request, Syllabus $syllabus): IntendedLearningOutcomeResource
    {
        $validated = $request->validated();
        $newPosition = $syllabus->intendedLearningOutcomes()->max('position') + 1;
        $validated['position'] = $newPosition;
        return new IntendedLearningOutcomeResource($syllabus->intendedLearningOutcomes()->create($validate));
    }

    /**
     * Display the specified resource.
     */
    public function show(IntendedLearningOutcome $ilo): IntendedLearningOutcomeResource
    {
        return new IntendedLearningOutcomeResource($ilo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIntendedLearningOutcomesRequest $request, IntendedLearningOutcome $ilo): IntendedLearningOutcomeResource|JsonResponse
    {
        $validated = $request->validated();
        if (empty($validated)) {
            return response()->json(['message' => 'Not modified'], 304);
        }
        $ilo->update($validated);
        return new IntendedLearningOutcomeResource($ilo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IntendedLearningOutcome $ilo)
    {
        $ilo->delete();
        return response()->json([
            'message' => 'Resource deleted'
        ]);
    }
}
