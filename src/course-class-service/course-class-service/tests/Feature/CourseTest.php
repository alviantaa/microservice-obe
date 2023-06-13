<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Course;

class CourseTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */


    public function testUserCanGetCourse()
    {
        // Data yang akan ditampilkan
         $courseData = [
             'id' => 1,
             'creator_user_id' => 1,
             'study_program_id' => 1,
             'name' => 'Pemrograman Web Lanjut',
             'code' => 'A123',
             'course_credit' => 3,
             'lab_credit'=> 1,
             'type'=> 'mandatory',
             'short_description' => 'Pemrograman Web tingkat Lanjut',
             'minimal_requirement' => 'Pemrograman Web',
             'study_material_summary' => null,
             'learning_media' => 'slack'
         ];
 
        //  Menampilkan data dengan method get
         $response = $this->get('/api/course', $courseData);

         $response->assertStatus(200);
     }
    
    public function testUserCanCreateCourse()
    {
        // Data yang akan dibuat oleh user
        $courseData = [
            'creator_user_id' => 1,
            'study_program_id' => 1,
            'name' => 'Pemrograman Web Lanjut',
            'code' => 'A123',
            'course_credit' => 3,
            'lab_credit' => 1,
            'type' => 'mandatory',
            'short_description' => 'Pemrograman Web tingkat Lanjut',
            'minimal_requirement' => 'Pemrograman Web',
            'study_material_summary' => null,
            'learning_media' => 'slack',
        ];

        // Membuat course menggunakan method post
        $response = $this->post('/api/course', $courseData);

        $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'Pemrograman Web Lanjut',
                'code' => 'A123',
            ]
        ]);

    }

    public function testUserCanUpdateCourse()
    {
        // Membuat course yang akan diubah
        $courseData = [
             'id' => 1,
             'creator_user_id' => 1,
             'study_program_id' => 1,
             'name' => 'Pemrograman Web Lanjut',
             'code' => 'A123',
             'course_credit' => 3,
             'lab_credit'=> 1,
             'type'=> 'mandatory',
             'short_description' => 'Pemrograman Web tingkat Lanjut',
             'minimal_requirement' => 'Pemrograman Web',
             'study_material_summary' => null,
             'learning_media' => 'slack'
        ];
        $createdCourse = Course::create($courseData);

        // Data baru untuk mengubah course
        $updatedCourseData = [
             'id' => 1,
             'creator_user_id' => 1,
             'study_program_id' => 1,
             'name' => 'Data Science',
             'code' => 'A123',
             'course_credit' => 3,
             'lab_credit'=> 1,
             'type'=> 'mandatory',
             'short_description' => 'Pemrograman Web tingkat Lanjut',
             'minimal_requirement' => 'Pemrograman Web',
             'study_material_summary' => null,
             'learning_media' => 'slack'
        ];

        // Mengirim permintaan put untuk mengubah course
        $response = $this->put('/api/course/' . $createdCourse['id'], $updatedCourseData);

        $response->assertRedirect();
        $this->assertDatabaseHas('courses', [
                'id' => 2,
                'name' => 'Pemrograman Web Lanjut',
                'code' => 'A123',
            ]);
        }

        public function testUserCanDeleteCourse()
    {
        // Membuat course yang akan dihapus
        $courseData = [
             'id' => 1,
             'creator_user_id' => 1,
             'study_program_id' => 1,
             'name' => 'Pemrograman Web Lanjut',
             'code' => 'A123',
             'course_credit' => 3,
             'lab_credit'=> 1,
             'type'=> 'mandatory',
             'short_description' => 'Pemrograman Web tingkat Lanjut',
             'minimal_requirement' => 'Pemrograman Web',
             'study_material_summary' => null,
             'learning_media' => 'slack'
        ];
        $createdCourse = Course::create($courseData);

        // Menghapus course menggunakan method delete
        $response = $this->delete('/api/course/' . $createdCourse->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('courses', ['id' => $createdCourse->id]);
    }

}
