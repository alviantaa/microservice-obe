<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentGrade;
use App\Models\StudentGradeDetail;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $criteriaMaxPoint = 6.25;
        $rubric = range(1, 4);
        $llo = range(1, 4);
        
        foreach ($rubric as $r) {
            foreach ($llo as $l) {
                $criteria = Criteria::factory(1)->create([
                    'rubric_id' => $r,
                    'llo_id' => $l,
                    'max_point' => $criteriaMaxPoint,
                ])->first();
            }
        }
        
        $point = range($criteriaMaxPoint, 1);
        foreach ($point as $p) {
            $criteriaLevel = CriteriaLevel::factory(1)->create([
                'criteria_id' => $criteria->id,
                'point' => $p,
            ])->first();
        }
        
        $suser = range(1, 4);
        $assignment = range(1, 4);
        foreach ($suser as $s) {
            foreach ($assignment as $a) {
                $studentGrade = StudentGrade::factory(1)->create([
                    'student_user_id' => $s,
                    'assignment_id' => $a,
                    'published' => true,
                ])->first();
                
                StudentGradeDetail::factory(1)->create([
                    'student_grade_id' => $studentGrade->id,
                    'assignment_plan_task_id' => $criteria->id, // Update with appropriate value
                    'criteria_level_id' => $criteriaLevel->id, // Update with appropriate value
                ]);
            }
        }
    }
}
