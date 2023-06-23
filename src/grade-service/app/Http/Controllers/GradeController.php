<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentGrades;
use App\Models\StudentGradeDetails;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        $usersData = file_get_contents('E:\kuliah\developer\Microservice\Grade-service\app\Http\Controllers\tabel\users.json');
        $arrayUsers = json_decode($usersData, true);
        $user = collect($arrayUsers)->firstWhere('id', $userId);

        $studentData = file_get_contents('E:\kuliah\developer\Microservice\Grade-service\app\Http\Controllers\tabel\StudentData.json');
        $arrayStudent = json_decode($studentData, true);
        $StudentGrade = collect($arrayUsers)->firstWhere('id', $userId);

        // Jika user dengan ID yang diberikan tidak ditemukan
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
          // Mendapatkan data courseClass yang sesuai dari file JSON CourseClass
        $CourseClassData = file_get_contents('E:\kuliah\developer\Microservice\Grade-service\app\Http\Controllers\tabel\CourseClass.json');
        $arrayCC = json_decode($CourseClassData, true);
        $CourseClass = collect($arrayCC)->where('user_id', $userId);

        // Mendapatkan data assignment yang sesuai dari file JSON assignments
          $assignmentsData = file_get_contents('E:\kuliah\developer\Microservice\Grade-service\app\Http\Controllers\tabel\Assignment.json');
          $arrayAssignment = json_decode($assignmentsData, true);
          $assignments = collect($arrayAssignment)->firstWhere('id', $StudentGrade['assignment_id']);
  
          // Jika tidak ada data assignment yang sesuai
          if (!$assignments) {
              return response()->json(['error' => 'Assignments not found'], 404);
          }

         foreach ($assignments as $assignment) {
            $array = [
                'note' => $assignment['note']
                // 'nilai' => $criteriaLevels->where('id', $assignment['id'])->sum('point')
            ];
            $data['assignments'][] = $array;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
