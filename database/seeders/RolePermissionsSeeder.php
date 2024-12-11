<?php

namespace Database\Seeders;

use App\Models\Teacher\Teacher;
use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    public function run()
    {
        $superTeacherRole = Role::firstOrCreate(
            ['name' => 'super_teacher'],
                ['guard_name' => 'teacher']
        );

        $manageCoursesPermission = Permission::firstOrCreate(
            ['name' => 'manage_courses'],
                ['guard_name' => 'teacher']
        );
        $superTeacherRole->givePermissionTo($manageCoursesPermission);

        $superTeacherUser = Teacher::create([
            'name'     => 'Super Teacher',
            'email'    => 'superteacher@teacher.com',
            'phone'    => '01068754372',
            'stage_id' => 1,
            'grade_id' => 1,
            'password' => bcrypt('password'),
        ]);
        $superTeacherUser->assignRole('super_teacher');
    }
}

