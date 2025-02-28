<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class RolePermissionSeeder.
 *
 * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/multiple-guards
 *
 * @package App\Database\Seeds
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Enable these options if you need same role and other permission for User Model
         * Else, please follow the below steps for admin guard
         */

        // Create Roles and Permissions
        // $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        // $roleAdmin = Role::create(['name' => 'admin']);
        // $roleEditor = Role::create(['name' => 'editor']);
        // $roleUser = Role::create(['name' => 'user']);


        // Permission List as array
        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                ]
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                ]
            ],
            [
                'group_name' => 'master data',
                'permissions' => [
                    'master.data.view',
                ]
            ],

            [
                'group_name' => 'kelas',
                'permissions' => [
                    'kelas.view',
                    'kelas.create',
                    'kelas.edit',
                    'kelas.delete',
                ]
            ],
           
            [
                'group_name' => 'siswa',
                'permissions' => [
                    'siswa.view',
                    'siswa.create',
                    'siswa.edit',
                    'siswa.delete',
                ]
            ],
           
            [
                'group_name' => 'guru',
                'permissions' => [
                    'guru.view',
                    'guru.create',
                    'guru.edit',
                    'guru.delete',
                ]
            ],
            [
                'group_name' => 'mata pelajaran',
                'permissions' => [
                    'mata.pelajaran.view',
                    'mata.pelajaran.create',
                    'mata.pelajaran.edit',
                    'mata.pelajaran.delete',
                ]
            ],
            [
                'group_name' => 'jadwal',
                'permissions' => [
                    'jadwal.all.data',
                    'jadwal.view',
                    'jadwal.create',
                    'jadwal.edit',
                    'jadwal.delete',
                ]
            ],
            [
                'group_name' => 'absensi',
                'permissions' => [
                    'absensi.view',
                    'absensi.all.data',
                ]
            ],
            [
                'group_name' => 'profile',
                'permissions' => [
                    'profile.view',
                ]
            ],
            [
                'group_name' => 'catatan',
                'permissions' => [
                    'catatan.all.data',
                    'catatan.view',
                    'catatan.create',
                    'catatan.edit',
                    'catatan.delete',
                ]
            ],
            [
                'group_name' => 'nilai.siswa',
                'permissions' => [
                    'nilai.siswa.all.data',
                    'nilai.siswa.view',
                    'nilai.siswa.create',
                    'nilai.siswa.edit',
                    'nilai.siswa.delete',
                ]
            ],
        ];

        // Do same for the admin guard for tutorial purposes.
        $admin = Admin::where('username', 'superadmin')->first();
        $roleSuperAdmin = $this->maybeCreateSuperAdminRole($admin);

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                $permissionExist = Permission::where('name', $permissions[$i]['permissions'][$j])->first();
                if (is_null($permissionExist)) {
                    $permission = Permission::create(
                        [
                            'name' => $permissions[$i]['permissions'][$j],
                            'group_name' => $permissionGroup,
                            'guard_name' => 'admin'
                        ]
                    );
                    $roleSuperAdmin->givePermissionTo($permission);
                    $permission->assignRole($roleSuperAdmin);
                }
            }
        }

        // Assign super admin role permission to superadmin user
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }
    }

    private function maybeCreateSuperAdminRole($admin): Role
    {
        if (is_null($admin)) {
            $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        } else {
            $roleSuperAdmin = Role::where('name', 'superadmin')->where('guard_name', 'admin')->first();
        }

        if (is_null($roleSuperAdmin)) {
            $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        }

        return $roleSuperAdmin;
    }
}
