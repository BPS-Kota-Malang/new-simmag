<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::firstOrCreate([
            'name' => 'Superadmin',
            'google_id' => 'Superadmin',
            'google_token' => 'Superadmin',
            'google_refresh_token' => 'Superadmin',
            'email' => 'superadmin@magang.bpskotamalang.id',
            'email_verified_at' => '2023-10-07 05:26:42',
            'password' => Hash::make('@passwordsuperadminmagang')
        ]);

        $superadmin->assignRole("Super Admin");
    }
}
