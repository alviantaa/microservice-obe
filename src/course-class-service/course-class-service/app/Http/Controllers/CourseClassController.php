<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CourseClassStoreRequest;
use App\Http\Requests\CourseClassUpdateRequest;
use App\Http\Resources\CourseClassResource;
use App\Models\CourseClass;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CourseClassController extends Controller
{
	public function index()
	{
		$courseclass = CourseClass::paginate(10);
		return CourseClassResource::collection($courseclass);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(CourseClassStoreRequest $request): CourseClassResource
	{
		$validated = $request->validated();
		return new CourseClassResource(CourseClass::create($validated));
	}

	/**
	 * Display the specified resource.
	 */
	public function show(CourseClass $CourseClass)
	{
		return new CourseClassResource($CourseClass);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(CourseClassUpdateRequest $request, CourseClass $courseClass): CourseClassResource|JsonResponse
	{
		$validated = $request->validated();
		if (empty($validated)) {
			return response()->json(['message' => 'Not modified'], 304);
		}

		$courseClass->update($request->all());
		return new CourseClassResource($courseClass);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(CourseClass $courseClass)
	{
		$courseClass->delete();
		return response()->json(['message' => 'CourseClass deleted']);
	}

	/**
	 * add students to a class
	 */
	public function addStudentToClass(Request $request)
	{
		$courseClass = CourseClass::find($request->input('course_class_id'));
		$user = User::find($request->input('student_user_id'));

		if ($courseClass->students()->where('student_user_id', $user->id)->exists()) {
			return response()->json([
				'success' => false,
				'message' => 'User already exists in the class',
			], 400);
		}

		$courseClass->students()->syncWithoutDetaching([$user->id]);

		return response()->json([
			'success' => true,
			'message' => 'User added to class',
		]);
	}

	public function viewStudentInClass(Request $request, $id)
	{
		$courseclass = CourseClass::find($id);

		return response()->json([
			'success' => true,
			'message' => 'Grabbed all students in the class',
			'data' => $courseclass->students()->get()
		]);
	}
}
