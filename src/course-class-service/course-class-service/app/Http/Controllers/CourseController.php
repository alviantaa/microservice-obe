<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
	public function index()
	{
		$course = Course::paginate(10);
		return CourseResource::collection($course);

		//Course::with('studyProgram')->get();
		//Course::with('creator')->get();
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(CourseStoreRequest $request): CourseResource
	{
		$validated = $request->validated();
		return new CourseResource(Course::create($validated));
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Course $Course): CourseResource
	{
		return new CourseResource($Course);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(CourseUpdateRequest $request, Course $course): CourseResource|JsonResponse
	{
		$validated = $request->validated();
        if (empty($validated)) {
            return response()->json(['message' => 'Not modified'], 304);
        }

		$course->update($request->all());
		return new CourseResource($course);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Course $Course): JsonResponse
	{
		$Course->delete();
		return response()->json(['message' => 'Course deleted']);
	}
}
