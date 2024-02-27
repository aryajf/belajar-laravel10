<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrcreate(['name' => 'admin'], ['name' => 'admin']);
        Role::updateOrcreate(['name' => 'writer'], ['name' => 'writer']);
        Role::updateOrcreate(['name' => 'guest'], ['name' => 'guest']);
    }
}
