<?php

namespace Database\Seeders;

use App\Models\Course\Course;
use App\Models\Grade\Grade;
use App\Models\Teacher\Teacher;
use App\Models\TeacherCourse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
        {
            $teacherIds = Teacher::pluck('id')->toArray();
            $courseIds = Course::pluck('id')->toArray();
            $gradeIds = Grade::pluck('id')->toArray();

            foreach ($teacherIds as $teacherId) {
                foreach ($courseIds as $courseId) {
                    foreach ($gradeIds as $gradeId) {
                        TeacherCourse::create([
                            'teacher_id' => $teacherId,
                            'course_id'  => $courseId,
                            'grade_id'   => $gradeId,
                        ]);
                    }
                }
            }
        }
}
