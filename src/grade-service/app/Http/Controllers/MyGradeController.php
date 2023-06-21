<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentGrades;
use App\Models\StudentGradeDetails;

class MyGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {

        // mendapatkan data dari model student Grade
        $studentGrade = StudentGrades::where('student_user_id', $userId)->get();

        // mendapatkan data dari model student Grade details
        $studentGradesDetail = StudentGradeDetails::whereIn('student_grade_id', $studentGrade->pluck('id'))->get();


        // Mendapatkan data user dari file JSON users
        $usersData = file_get_contents('E:\kuliah\developer\Microservice\Grade-service\app\Http\Controllers\tabel\users.json');
        $arrayUsers = json_decode($usersData, true);
        $user = collect($arrayUsers)->firstWhere('id', $userId);

        // Jika user dengan ID yang diberikan tidak ditemukan
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Mendapatkan data level criteria dari file JSON criteria levels
        $criteriaLevelsData = file_get_contents('E:\kuliah\developer\Microservice\Grade-service\app\Http\Controllers\tabel\CriteriaLevel.json');
        $arrayCL = json_decode($criteriaLevelsData, true);
        $grades = $studentGradesDetail->filter(function ($grade) use ($arrayCL) {
            $criteriaLevel = collect($arrayCL)->where('id', $grade->criteria_level_id)->first();
            return $criteriaLevel !== null;
         })->map(function ($grade) use ($arrayCL) {
            $criteriaLevel = collect($arrayCL)->where('id', $grade->criteria_level_id)->first();
            return [
                'point' => $criteriaLevel['point']
            ];
        });

        $totalPoint = $grades->sum('point');
        $pointCount = $grades->pluck('point')->count();
        $maxPoint = 6.25;
        $maxPointCount = $maxPoint * $pointCount;
        $angkaPoint = ($totalPoint/$maxPointCount)*100;
        $userClass = $this->_getLetterGrade($angkaPoint);

        // Jika criteria level dengan ID yang sesuai tidak ditemukan
        if (!$grades) {
            return response()->json(['error' => 'Gradenot found'], 404);
        };
        // Mengambil data yang diperlukan
        $data = [
                'name' => $user['name'],
                'total' => $totalPoint,
                'angka' => $angkaPoint,
                'letter' => $userClass,                
                // 'point' => $grades
        ];
        
       
        return $data;

    }


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
          // // Mendapatkan data courseClass yang sesuai dari file JSON CourseClass
        // $CourseClassData = file_get_contents('E:\kuliah\developer\Microservice\Grade-service\app\Http\Controllers\tabel\CourseClass.json');
        // $arrayCC = json_decode($CourseClassData, true);
        // $CourseClass = collect($arrayCC)->where('user_id', $userId);

        // // Jika tidak ada data assignment yang sesuai
        // if ($assignments->isEmpty()) {
        //     return response()->json(['error' => 'Assignments not found'], 404);
        // }

          // Mendapatkan data assignment yang sesuai dari file JSON assignments
        //   $assignmentsData = file_get_contents('E:\kuliah\developer\Microservice\Grade-service\app\Http\Controllers\tabel\Assignment.json');
        //   $arrayAssignment = json_decode($assignmentsData, true);
        //   $assignments = collect($arrayAssignment)->firstWhere('id', $StudentGrade['assignment_id']);
  
        //   // Jika tidak ada data assignment yang sesuai
        //   if (!$assignments) {
        //       return response()->json(['error' => 'Assignments not found'], 404);
        //   }

         // foreach ($assignments as $assignment) {
        //     $array = [
        //         'note' => $assignment['note']
        //         // 'nilai' => $criteriaLevels->where('id', $assignment['id'])->sum('point')
        //     ];
        //     $data['assignments'][] = $array;
        // }

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

    public function _getLetterGrade($point)
    {
        if ($point > 80) {
            return 'A';
        } elseif ($point > 75) {
            return 'B+';
        } elseif ($point > 69) {
            return 'B';
        } elseif ($point > 60) {
            return 'C+';
        } elseif ($point > 55) {
            return 'C';
        } elseif ($point > 50) {
            return 'D+';
        } elseif ($point > 44) {
            return 'D';
        } else {
            return 'E';
        }
    }
}

