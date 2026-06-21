<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder {
    public function run(): void {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $permissions = [
            'view courses', 'create courses', 'edit courses', 'delete courses',
            'manage enrolments', 'view enrolments',
            'manage payments', 'view payments',
            'manage users', 'view users',
            'view reports', 'manage settings',
            'manage assessments', 'submit assessments',
            'view certificates', 'manage certificates',
        ];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
        $roles = [
            'super_admin' => $permissions,
            'admin' => [
                'view courses', 'create courses', 'edit courses', 'delete courses',
                'manage enrolments', 'view enrolments',
                'manage payments', 'view payments',
                'manage users', 'view users',
                'view reports', 'manage settings',
                'manage assessments', 'manage certificates',
            ],
            'trainer' => [
                'view courses', 'create courses', 'edit courses',
                'view enrolments', 'manage assessments',
                'view reports',
            ],
            'corporate_hr' => [
                'view courses', 'view enrolments', 'manage enrolments',
                'view payments', 'view reports', 'view users',
            ],
            'delegate' => [
                'view courses', 'view enrolments', 'submit assessments', 'view certificates',
            ],
        ];
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
