<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CourseClass;

class CourseClassTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */


    public function testUserCanGetCourseClass()
    {
        // Data yang akan ditampilkan
         $courseClassData = [
            'id' => 1,
            'course_id' => 1,
            'name' => 'A',
            'thumbnail_img' => 'image.png',
            'class_code' => 'A123',
            'creator_user_id' => 2,
            'syllabus_id' => 1
         ];
 
        //  Menampilkan data dengan method get
         $response = $this->get('/api/course-class', $courseClassData);

         $response->assertStatus(200);
     }
    
    public function testUserCanCreateCourseClass()
    {
        // Data yang akan dibuat oleh user
        $courseClassData = [
            'id' => 1,
            'course_id' => 1,
            'name' => 'A',
            'thumbnail_img' => 'image.png',
            'class_code' => 'A123',
            'creator_user_id' => 2,
            'syllabus_id' => 1
        ];

        // Membuat course class menggunakan method post
        $response = $this->post('/api/course-class', $courseClassData);

        $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'A',
                'class_code' => 'A123',
            ]
        ]);

    }

    public function testUserCanUpdateCourseClass()
    {
        // Membuat course class yang akan diubah
        $courseClassData = [
            'id' => 1,
            'course_id' => 1,
            'name' => 'A',
            'thumbnail_img' => 'image.png',
            'class_code' => 'A123',
            'creator_user_id' => 2,
            'syllabus_id' => 1
        ];
        $createdCourseClass = CourseClass::create($courseClassData);

        // Data baru untuk mengubah course
        $updatedCourseClassData = [
            'id' => 2,
            'course_id' => 1,
            'name' => 'B',
            'thumbnail_img' => 'image.png',
            'class_code' => 'A123',
            'creator_user_id' => 2,
            'syllabus_id' => 1
        ];

        // Mengirim permintaan put untuk mengubah course
        $response = $this->put('/api/course-class/' . $createdCourseClass['id'], $updatedCourseClassData);

        $this->assertDatabaseHas('course_classes', [
            'id' => 2,
            'name' => 'B',
        ]);
    }

        public function testUserCanDeleteCourseClass()
    {
        // Membuat course class yang akan dihapus
        $courseClassData = [
            'id' => 1,
            'course_id' => 1,
            'name' => 'B',
            'thumbnail_img' => 'image.png',
            'class_code' => 'A123',
            'creator_user_id' => 2,
            'syllabus_id' => 1
        ];
        $createdCourseClass = CourseClass::create($courseClassData);

        // Menghapus course class menggunakan method delete
        $response = $this->delete('/api/course-class/' . $createdCourseClass->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('course_classes', ['id' => $createdCourseClass->id]);
    }
    
}