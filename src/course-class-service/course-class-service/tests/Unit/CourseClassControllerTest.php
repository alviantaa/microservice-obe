<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CourseClass;


class CourseClassControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */


     public function testCourseClassNameIsRequired()
    {
        $courseClassData = [
            'id' => 1,
            'course_id' => 1,
            'thumbnail_img' => 'image.png',
            'class_code' => 'A123',
            'creator_user_id' => 2,
            'syllabus_id' => 1
        ];

        $this->expectException(\Illuminate\Database\QueryException::class);

        CourseClass::create($courseClassData);
    }


    public function testCourseClassThumbnailImageIsAString()
    {
        $courseClassData = [
            'id' => 1,
            'course_id' => 1,
            'name' => 'A',
            'thumbnail_img' => 'image.png',
            'class_code' => 'A123',
            'creator_user_id' => 2,
            'syllabus_id' => 1
        ];

        $courseClass = CourseClass::create($courseClassData);

        $this->assertIsString($courseClass->thumbnail_img);
    }

}
			