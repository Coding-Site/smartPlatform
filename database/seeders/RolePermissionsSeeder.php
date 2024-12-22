<?php

namespace Database\Seeders;

use App\Models\Teacher\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'guard_name' => 'teacher',
                'translations' => [
                    'en' => ['name' => 'Super Teacher'],
                    'ar' => ['name' => 'المعلم المتميز'],
                ],
                'permissions' => [
                    [
                        'guard_name' => 'teacher',
                        'translations' => [
                            'en' => ['name' => 'Manage Courses'],
                            'ar' => ['name' => 'إدارة الدورات'],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::create([
                'guard_name' => $roleData['guard_name'],
            ]);

            foreach ($roleData['translations'] as $locale => $translation) {
                DB::table('role_translations')->insert([
                    'role_id' => $role->id,
                    'locale' => $locale,
                    'name' => $translation['name'],
                ]);
            }

            foreach ($roleData['permissions'] as $permissionData) {
                $permission = Permission::create([
                    'guard_name' => $permissionData['guard_name'],
                ]);

                $role->givePermissionTo($permission);

                foreach ($permissionData['translations'] as $locale => $translation) {
                    DB::table('permission_translations')->insert([
                        'permission_id' => $permission->id,
                        'locale' => $locale,
                        'name' => $translation['name'],
                    ]);
                }
            }
        }

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
