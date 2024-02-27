<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::updateOrcreate(['name' => 'admin'], ['name' => 'admin']);
        $roleWriter = Role::updateOrcreate(['name' => 'writer'], ['name' => 'writer']);
        $roleGuest = Role::updateOrcreate(['name' => 'guest'], ['name' => 'guest']);
        $permission = Permission::updateOrCreate(['name' => 'view_dashboard'], ['name' => 'view_dashboard']);
        $permission2 = Permission::updateOrCreate(['name' => 'view_chart_on_dashboard'], ['name' => 'view_chart_on_dashboard']);

        $roleAdmin->givePermissionTo($permission);
        $roleAdmin->givePermissionTo($permission2);
        $roleWriter->givePermissionTo($permission2);
        $user = User::find(1);
        $user->assignRole('admin');
    }
}
