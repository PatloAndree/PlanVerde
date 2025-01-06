<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'superadministrador']);
        Role::create(['name' => 'administrador']);
        Role::create(['name' => 'cliente']);
        Role::create(['name' => 'marketing']);
        Role::create(['name' => 'soporte']);
    }
}
