<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $permissions = [

            // Roles
            ['group' => 'roles', 'name' => 'view_roles', 'title' => 'View Roles', 'guard_name' => 'web'],
            // ['group' => 'roles', 'name' => 'add_role', 'title' => 'Add Role', 'guard_name' => 'web'],
            ['group' => 'roles', 'name' => 'edit_role', 'title' => 'Edit Role', 'guard_name' => 'web'],
            ['group' => 'roles', 'name' => 'delete_role', 'title' => 'Delete Role', 'guard_name' => 'web'],

            // Users
            ['group' => 'users', 'name' => 'view_users', 'title' => 'View Users', 'guard_name' => 'web'],
            ['group' => 'users', 'name' => 'add_user', 'title' => 'Add User', 'guard_name' => 'web'],
            ['group' => 'users', 'name' => 'edit_user', 'title' => 'Edit User', 'guard_name' => 'web'],
            ['group' => 'users', 'name' => 'delete_user', 'title' => 'Delete User', 'guard_name' => 'web'],

            // Patients
            ['group' => 'patients', 'name' => 'view_patients', 'title' => 'View Patients', 'guard_name' => 'web'],
            ['group' => 'patients', 'name' => 'add_patient', 'title' => 'Add Patient', 'guard_name' => 'web'],
            ['group' => 'patients', 'name' => 'edit_patient', 'title' => 'Edit Patient', 'guard_name' => 'web'],
            ['group' => 'patients', 'name' => 'delete_patient', 'title' => 'Delete Patient', 'guard_name' => 'web'],

            // Prescription and Reports
            ['group' => 'prescriptions_&_reports', 'name' => 'write_prescription', 'title' => 'Write Prescription', 'guard_name' => 'web'],
            ['group' => 'prescriptions_&_reports', 'name' => 'view_reports', 'title' => 'View Reports', 'guard_name' => 'web'],
            ['group' => 'prescriptions_&_reports', 'name' => 'approve_or_reject_report', 'title' => 'Approve or Reject Report', 'guard_name' => 'web'],

        ];
        Permission::insert($permissions);
    }
}
