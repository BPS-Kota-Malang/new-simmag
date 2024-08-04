<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KetuaTimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $subbag = User::firstOrCreate([
            'name' => 'Subbag Umum',
            'google_id' => 'Subbag Umum',
            'google_token' => 'Subbag Umum',
            'google_refresh_token' => 'Subbag Umum',
            'email' => 'subbagumum@magang.bpskotamalang.id',
            'email_verified_at' => '2023-10-07 05:26:42',
            'password' => Hash::make('@passwordsubbagumummagang')
        ]);
        Employee::firstOrCreate([
            'name' => 'Arini Ismiati S.ST',
            'nip' => '197912202003122006',
            'user_id' => $subbag->id,
            'division_id' => 1
        ]);

        $sosial = User::firstOrCreate([
            'name' => 'Sosial',
            'google_id' => 'Sosial',
            'google_token' => 'Sosial',
            'google_refresh_token' => 'Sosial',
            'email' => 'sosial@magang.bpskotamalang.id',
            'email_verified_at' => '2023-10-07 05:26:42',
            'password' => Hash::make('@passwordsosialmagang')
        ]);
        Employee::firstOrCreate([
            'name' => 'Ir. Ernawaty M.M',
            'nip' => '196701091992032001',
            'user_id' => $sosial->id,
            'division_id' => 2
        ]);
        $distribusi = User::firstOrCreate([
            'name' => 'Distribusi',
            'google_id' => 'Distribusi',
            'google_token' => 'Distribusi',
            'google_refresh_token' => 'Distribusi',
            'email' => 'distribusi@magang.bpskotamalang.id',
            'email_verified_at' => '2023-10-07 05:26:42',
            'password' => Hash::make('@passworddistribusimagang')
        ]);
        Employee::firstOrCreate([
            'name' => 'Ir. Dwi Handayani Prasetyawati M.AP',
            'nip' => '196810281994012001',
            'user_id' => $distribusi->id,
            'division_id' => 3
        ]);
        $produksi = User::firstOrCreate([
            'name' => 'Produksi',
            'google_id' => 'Produksi',
            'google_token' => 'Produksi',
            'google_refresh_token' => 'Produksi',
            'email' => 'produksi@magang.bpskotamalang.id',
            'email_verified_at' => '2023-10-07 05:26:42',
            'password' => Hash::make('@passwordproduksimagang')
        ]);
        Employee::firstOrCreate([
            'name' => 'Ir. Agustina Martha M.M.',
            'nip' => '196808231994012001',
            'user_id' => $produksi->id,
            'division_id' => 5
        ]);
        $neraca = User::firstOrCreate([
            'name' => 'Neraca',
            'google_id' => 'Neraca',
            'google_token' => 'Neraca',
            'google_refresh_token' => 'Neraca',
            'email' => 'neraca@magang.bpskotamalang.id',
            'email_verified_at' => '2023-10-07 05:26:42',
            'password' => Hash::make('@passwordneracamagang')
        ]);
        Employee::firstOrCreate([
            'name' => 'Tasmilah SST, M.E.',
            'nip' => '198309102006022001',
            'user_id' => $neraca->id,
            'division_id' => 4
        ]);
        $ipds = User::firstOrCreate([
            'name' => 'IPDS',
            'google_id' => 'IPDS',
            'google_token' => 'IPDS',
            'google_refresh_token' => 'IPDS',
            'email' => 'ipds@magang.bpskotamalang.id',
            'email_verified_at' => '2023-10-07 05:26:42',
            'password' => Hash::make('@passwordipdsmagang')
        ]);
        Employee::firstOrCreate([
            'name' => 'Ir. Wahyu Furqandari M.M.',
            'nip' => '196901181994012001',
            'user_id' => $ipds->id,
            'division_id' => 6
        ]);

        $subbag -> assignRole ('Subbag Umum');
        $sosial -> assignRole ('Ketua Tim');
        $distribusi -> assignRole ('Ketua Tim');
        $produksi -> assignRole ('Ketua Tim');
        $neraca -> assignRole ('Ketua Tim');
        $ipds -> assignRole ('Ketua Tim');
    }
}
