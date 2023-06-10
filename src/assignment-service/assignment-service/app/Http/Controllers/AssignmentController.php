<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\CourseClass;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        abort(404);
    }

    // private function _getAvailableAssignmentPlans(CourseClass $class){
    //     $syllabus = $class->syllabus()->with('assignmentPlans')->first();

    //     if (empty($syllabus)){ abort(404); }

    //     // get AssignmentPlan that is not used by this class
    //     return $syllabus->assignmentPlans()
    //         ->whereNotIn('id', $class->assignments()->pluck('assignment_plan_id'))->get();
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @param CourseClass $class
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CourseClass $class
     * @param Assignment $assignment
     * @return RedirectResponse
     * @throws ValidationException|AuthorizationException
     */
    public function store(Request $request,  Assignment $assignment)
    {
        // $this->authorize('store', [Assignment::class]);

        $validator = Validator::make($request->all(), [
            'assignment_plan_id' => 'required|numeric',
            'course_class_id' => 'required|numeric',
            'due_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        // $validator->after(function ($validator) use ($request, $class) {
        //     $availableAssignmentPlans = $this->_getAvailableAssignmentPlans($class);

        //     if ($availableAssignmentPlans->isEmpty()) {
        //         $validator->errors()->add('assignment_plan_id', 'You have no assignment plan available to create an assignment');
        //     }

        //     if (!$availableAssignmentPlans->contains('id', $request->assignment_plan_id)) {
        //         $validator->errors()->add('assignment_plan_id', 'The selected assignment plan is invalid.');
        //     }
        // });

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data Invalid',
            ], 400);
        }

        $validated = $validator->validated();

        $assignment->assignment_plan_id = $validated['assignment_plan_id'];
        $assignment->course_class_id = $validated['course_class_id'];
        $assignment->assigned_date = Carbon::now('Asia/Jakarta');
        $assignment->due_date = $validated['due_date'];
        $assignment->note = $validated['note'];

        $assignment->save();

        return response()->json([
            'message' => 'Assignment created',
            'assignment' => $assignment
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param CourseClass $class
     * @param Assignment $assignment
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function show(Request $request, Assignment $assignment)
    {
        $assignment = Assignment::find($request->id);

        if (empty($assignment)) {
			return response()->json([
				'success' => false,
				'message' => 'Assignment Not Found',
			], 400);
		}
        return response()->json([
            'success' => true, 
            'message' => 'Assignment Data',
            'data' => $assignment
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CourseClass $class
     * @param Assignment $assignment
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit( Assignment $assignment)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CourseClass $class
     * @param Assignment $assignment
     * @return RedirectResponse
     * @throws ValidationException|AuthorizationException
     */
    public function update(Request $request,  Assignment $assignment)
    {
        $assignment = Assignment::find($request->id);

        $validator = Validator::make($request->all(), [
            'assignment_plan_id' => 'required|numeric',
            'due_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $assignment->update($validated);

        return response()->json([
            'message' => 'Assignment created',
            'assignment' => $assignment
        ], 200);    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Assignment $assignment
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy( Request $request, Assignment $assignment)
    {
        $assignment = Assignment::find($request->id);
        $assignment->delete();
        return response()->json(['message' => 'Assignment deleted'], 200);
    }
}
