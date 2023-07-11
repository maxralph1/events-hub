<?php

namespace Database\Seeders;

use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'title' => 'super-admin',
        ]);

        Role::create([
            'title' => 'admin',
        ]);

        Role::create([
            'title' => 'generic-user',
        ]);
    }
}
