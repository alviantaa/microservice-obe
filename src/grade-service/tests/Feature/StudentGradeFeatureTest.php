<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\StudentGrades;

class StudentGradeFeatureTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */


    public function testUserCanGetStudentGrade()
    {
        // Data yang akan ditampilkan
        $StudentGradeData = [
            'id' => 1,
            'student_user_id' => 1,
            'assignment_id' => '1',
            'published' => '1'
        ];

        //  Menampilkan data dengan method get
        $response = $this->get('/api/student-grades', $StudentGradeData);

        $response->assertStatus(200);
    }

    public function testUserCanCreateStudentGrade()
    {
        // Data yang akan dibuat oleh user
        $StudentGradeData = [
            'id' => 70,
            'student_user_id' => 1,
            'assignment_id' => '1',
            'published' => '1'
        ];

        // Membuat course class menggunakan method post
        $response = $this->post('/api/student-grades', $StudentGradeData);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'student_user_id' => 1,
                    'assignment_id' => '1',
                ]
            ]);
    }

    public function testUserCanUpdateStudentGrade()
    {
        // Membuat course class yang akan diubah
        $StudentGradeData = [
            'id' => 2,
            'student_user_id' => 1,
            'assignment_id' => '7',
            'published' => '1'
        ];
        $createdStudentGrade = StudentGrades::create($StudentGradeData);

        // Data baru untuk mengubah course
        $updatedStudentGradeData = [
            'id' => 2,
            'student_user_id' => 1,
            'assignment_id' => '90',
            'published' => '1'
        ];

        // Mengirim permintaan put untuk mengubah course
        $response = $this->put('/api/student-grades/' . $createdStudentGrade['id'], $updatedStudentGradeData);

        $this->assertDatabaseHas('student_grades', [
            'student_user_id' => 1,
            'assignment_id' => '90',
        ]);
    }

    public function testUserCanDeleteStudentGrade()
    {
        // Membuat course class yang akan dihapus
        $StudentGradeData = [
            'id' => 5,
            'student_user_id' => 1,
            'assignment_id' => '1',
            'published' => '1'
        ];
        $createdStudentGrade = StudentGrades::create($StudentGradeData);

        // Menghapus course class menggunakan method delete
        $response = $this->delete('/api/student-grades/' . $createdStudentGrade->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('student_grades', ['id' => $createdStudentGrade->id]);
    }
}
