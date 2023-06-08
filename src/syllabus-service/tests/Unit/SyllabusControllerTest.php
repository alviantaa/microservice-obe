<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Syllabus;

class SyllabusControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testSyllabusCanBeCreated()
    {
         $syllabusData = [
            'id' => 1,
            'course' => 'Microservice',
            'title' => 'MA',
            'author' => 'Andrisan',
            'head_of_study_program' => 'Issa Arwani',
            'creator_user_id' => 123456
         ];
 
         $syllabus = Syllabus::create($syllabusData);
 
         $this->assertInstanceOf(Syllabus::class, $syllabus);
         $this->assertEquals('Microservice', $syllabus->course);
         $this->assertEquals('MA', $syllabus->title);
    }
}
