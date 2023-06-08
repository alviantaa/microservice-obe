<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Syllabus;

class SyllabusTest extends TestCase{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testUserCanGetSyllabus()
    {
        $syllabusData = [
            'id' => 1,
            'course' => 'Microservice',
            'title' => 'MA',
            'author' => 'Andrisan',
            'head_of_study_program' => 'Issa Arwani',
            'creator_user_id' => 123456
        ];

        $response = $this->get('/api/syllabi', $syllabusData);
        $response->assertStatus(200);
    }

    public function testUserCanCreateSyllabus()
    {
        $syllabusData = [
            'id' => 1,
            'course' => 'Microservice',
            'title' => 'MA',
            'author' => 'Andrisan',
            'head_of_study_program' => 'Issa Arwani',
            'creator_user_id' => 123456
        ];

        $response = $this->post('/api/syllabi', $syllabusData);
        $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'id' => 1,
                'course' => null,
                'title' => 'MA',
                'author' => 'Andrisan',
                'head_of_study_program' => 'Issa Arwani',
                'creator_user_id' => 123456
            ]
        ]);
    }

    public function testUserCanUpdateSyllabus()
    {
        $syllabusData = [
            'id' => 1,
            'course' => 'Microservice',
            'title' => 'MA',
            'author' => 'Andrisan',
            'head_of_study_program' => 'Issa Arwani',
            'creator_user_id' => 123456
        ];
        $createdSyllabus = Syllabus::create($syllabusData);

        $updatedSyllabusData = [
            'id' => 1,
            'course' => 'Microservice',
            'title' => 'MA',
            'author' => 'Andrisan',
            'head_of_study_program' => 'Issa Arwani',
            'creator_user_id' => 123456
        ];

        $response = $this->put('/api/syllabi/' . $createdSyllabus['id'], $updatedSyllabusData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('syllabi', [
            'id' => 2,
            'course' => 'Microservice',
            'title' => 'MA',
            'author' => 'Andrisan',
            'head_of_study_program' => 'Issa Arwani',
            'creator_user_id' => 123456
        ]);
    }

    public function testUserCanDeleteSyllabus()
    {
        $syllabusData = [
            'id' => 1,
            'course' => 'Microservice',
            'title' => 'MA',
            'author' => 'Andrisan',
            'head_of_study_program' => 'Issa Arwani',
            'creator_user_id' => 123456
        ];
        $createdSyllabus = Syllabus::create($syllabusData);

        $response = $this->delete('/api/syllabi/' . $createdSyllabus->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('syllabi', ['id' => $createdSyllabus->id]);
    }
}