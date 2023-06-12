<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Assignment;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Tests\TestCase;


class UnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_assignment(): void
    {
        // $assignment_data = [
        //     'assignment_plan_id' => $assignment_plan_id = 1,
        //     'course_class_id' => $class_course_id = 2,
        //     'assigned_date' => $assigned_date = Carbon::now('Asia/Jakarta'),
        //     'due_date' => $due_date = Carbon::now('Asia/Jakarta'),
        //     'note' => $note = 'THIS IS A NOTE'
        // ];

        // $assignment = Assignment::create($assignment_data);


        // $validator = Validator::make($assignment_data->all(), [
        //     'assignment_plan_id' => 'required|numeric',
        //     'course_class_id' => 'required|numeric',
        //     'due_date' => 'nullable|date',
        //     'note' => 'nullable|string',
        // ]);
        
        // $request = $validator->validated();
        // $request->assertValid();

    }
}