<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***
         * Seeder For Spatie
         */

         Role::create(['name' => 'Super Admin']);
         Role::create(['name' => 'Ketua Tim']);
         Role::create(['name' => 'Intern']);
         Role::create(['name' => 'Applicant']);
         Role::create(['name' => 'User']);
    }
}
