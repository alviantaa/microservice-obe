<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Course;


class CourseControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

     public function testCourseNameIsRequired()
    {
        $courseData = [
            'creator_user_id' => 1,
            'study_program_id' => 1,
            'code' => 'A123',
            'course_credit' => 3,
            'lab_credit' => 1,
            'type' => 'mandatory',
            'short_description' => 'Pemrograman Web tingkat Lanjut',
            'minimal_requirement' => 'Pemrograman Web',
            'study_material_summary' => null,
            'learning_media' => 'slack',
        ];

        $this->expectException(\Illuminate\Database\QueryException::class);

        Course::create($courseData);
    }

    public function testCourseStudyMaterialSummaryIsOptional()
    {
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
            'learning_media' => 'slack',
        ];

        $course = Course::create($courseData);

        $this->assertInstanceOf(Course::class, $course);
        $this->assertEquals('Pemrograman Web Lanjut', $course->name);
        $this->assertEquals('A123', $course->code);
        $this->assertNull($course->study_material_summary);
    }

}
			