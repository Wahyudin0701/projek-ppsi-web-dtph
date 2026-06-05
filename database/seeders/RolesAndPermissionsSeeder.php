<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage-users',
            'manage-roles',
            'manage-permissions',
            'view-audit-logs',
            'manage-programs',
            'manage-alsintan',
            'view-proposals',
            'approve-proposals', // generic approve
            'reject-proposals',  // generic reject
            'assign-survey-team',
            'verify-cpcl',
            'submit-proposals',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and assign existing permissions
        
        // Super Admin gets all permissions via Gate::before rule in AuthServiceProvider, 
        // but we create the role anyway.
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'manage-users',
            'manage-programs',
            'manage-alsintan',
            'view-proposals',
            'approve-proposals',
            'reject-proposals'
        ]);

        $pimpinan = Role::firstOrCreate(['name' => 'pimpinan']);
        $pimpinan->givePermissionTo([
            'view-proposals',
            'approve-proposals',
            'reject-proposals'
        ]);

        $kabidPsp = Role::firstOrCreate(['name' => 'kabid_psp']);
        $kabidPsp->givePermissionTo([
            'view-proposals',
            'assign-survey-team',
            'verify-cpcl',
        ]);

        $kabidTp = Role::firstOrCreate(['name' => 'kabid_tp']);
        $kabidTp->givePermissionTo([
            'view-proposals',
            'assign-survey-team',
            'verify-cpcl',
        ]);

        $kabidHorti = Role::firstOrCreate(['name' => 'kabid_hortikultura']);
        $kabidHorti->givePermissionTo([
            'view-proposals',
            'assign-survey-team',
            'verify-cpcl',
        ]);

        $user = Role::firstOrCreate(['name' => 'user']);
        $user->givePermissionTo(['submit-proposals']);

        $umum = Role::firstOrCreate(['name' => 'umum']);

        // Migrate existing users to new Spatie roles
        $users = User::all();
        foreach ($users as $u) {
            // Check if user already has the role to prevent duplicates if seeder runs multiple times
            if (!$u->hasRole($u->role)) {
                // For super_admin, we might not have a string role for it yet, 
                // but let's assign Admin DTPH as super_admin as well.
                if ($u->email === 'admin@dtph.com' || $u->role === 'admin') {
                    $u->assignRole('admin');
                } else if ($u->email === 'superadmin@dtph.com' || $u->role === 'super_admin') {
                    $u->assignRole('super_admin');
                } else {
                    // Make sure the role exists before assigning
                    if (Role::where('name', $u->role)->exists()) {
                        $u->assignRole($u->role);
                    }
                }
            }
        }
    }
}
