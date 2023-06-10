<?php

namespace Tests\Feature;

use App\Models\Assignment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;
use Tests\TestCase;

class FeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_single_assignment(): void
    {
        $response = $this->get('/assignment/70');

        $response->assertStatus(200);
    }

    public function test_post_single_assignment(): void
    {
        $token = csrf_token();
        $response = $this->withHeaders(['X-CSRF-TOKEN' => $token])->post('/assignment', 
                    [
                        'assignment_plan_id' => $assignment_plan_id = 5,
                        'course_class_id' => $class_course_id = 2,
                        'assigned_date' => $assigned_date = Carbon::now('Asia/Jakarta'),
                        'due_date' => $due_date = Carbon::now('Asia/Jakarta'),
                        'note' => $note = 'THIS IS A NOTE NEW'
                    ]);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('assignments', [
            'assignment_plan_id' => 5,
            'note' => 'THIS IS A NOTE NEW',
        ]);    
    }

    public function test_post_single_wrong_assignment(): void
    {
        $token = csrf_token();
        $response = $this->withHeaders(['X-CSRF-TOKEN' => $token])->post('/assignment', 
                    [
                        'assignment_plan_id' => $assignment_plan_id = 'wrong',
                        'course_class_id' => $class_course_id = 2,
                        'assigned_date' => $assigned_date = Carbon::now('Asia/Jakarta'),
                        'due_date' => $due_date = Carbon::now('Asia/Jakarta'),
                        'note' => $note = 1
                    ]);
        
        $response->assertStatus(400);

    }

    public function test_delete_single_assignment(): void
    {
        $assignment_data = [
            'id' => 6,
            'assignment_plan_id' => $assignment_plan_id = 1,
            'course_class_id' => $class_course_id = 2,
            'assigned_date' => $assigned_date = Carbon::now('Asia/Jakarta'),
            'due_date' => $due_date = Carbon::now('Asia/Jakarta'),
            'note' => $note = 'THIS IS A NOTE'
        ];

        $assignment = Assignment::create($assignment_data);

        $response = $this->delete('/assignment/'.$assignment->id);
        
        $response->assertSuccessful();
    }

    public function test_wrong_route(): void
    {
        $token = csrf_token();
        $response = $this->withHeaders(['X-CSRF-TOKEN' => $token])->delete('/assignment', 
                    [
                        'id' => $id = 1,
                    ]);
        
        $response->assertStatus(405);
    }

    public function test_update_single_assignment(): void
    {
        $assignment_data = [
            'id' => 6,
            'assignment_plan_id' => $assignment_plan_id = 3,
            'course_class_id' => $class_course_id = 2,
            'assigned_date' => $assigned_date = Carbon::now('Asia/Jakarta'),
            'due_date' => $due_date = Carbon::now('Asia/Jakarta'),
            'note' => $note = 'THIS IS A NOTE'
        ];

        $assignment = Assignment::create($assignment_data);

        $assignment_updated_data = [
            'assignment_plan_id'=>$assignment_plan_id = 3,
            'note' => $note = 'THIS IS A NOTE UPDATED'
        ];
        $token = csrf_token();

        $response = $this->withHeaders(['X-CSRF-TOKEN' => $token])->patch('/assignment/'.$assignment->id, $assignment_updated_data);
        
        $response->assertSuccessful();
        $this->assertDatabaseHas('assignments', [
            'assignment_plan_id' => 3,
            'note' => 'THIS IS A NOTE UPDATED',
        ]);
    }
}
