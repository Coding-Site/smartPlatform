<?php

namespace Database\Seeders;

use App\Models\Teacher\Teacher;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superTeacherRole = Role::Create(
            ['guard_name' => 'teacher']
        );

        $manageCoursesPermission = Permission::Create(
            ['guard_name' => 'teacher']
        );

        $superTeacherRole->givePermissionTo($manageCoursesPermission);

        DB::table('role_translations')->insert([
            ['role_id' => $superTeacherRole->id, 'locale' => 'en', 'name' => 'Super Teacher'],
            ['role_id' => $superTeacherRole->id, 'locale' => 'ar', 'name' => 'المعلم المتميز']
        ]);

        DB::table('permission_translations')->insert([
            ['permission_id' => $manageCoursesPermission->id, 'locale' => 'en', 'name' => 'Manage Courses'],
            ['permission_id' => $manageCoursesPermission->id, 'locale' => 'ar', 'name' => 'إدارة الدورات']
        ]);

        $superTeacherUser = Teacher::create([
            'name'     => 'Super Teacher',
            'email'    => 'superteacher@teacher.com',
            'phone'    => '01068754372',
            'stage_id' => 1,
            'grade_id' => 1,
            'password' => bcrypt('password'),
        ]);

        $superTeacherUser->assignRole('super_teacher');

        $this->command->info("Role and Permissions seeded successfully!");
    }
}
