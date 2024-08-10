<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::create([
            'name' => 'Sub Bagian Umum',
            'description' => 'Sub Bagian Umum.',
        ]);
        Division::create([
            'name' => 'Ketahanan Sosial, SUSENAS dan Sakerduk',
            'description' => 'Responsible for developing software solutions.',
        ]);

        Division::create([
            'name' => 'Harga, Distribusi dan Jasa',
            'description' => 'Responsible for developing software solutions.',
        ]);
        Division::create([
            'name' => 'Analis, Neraca Produksi dan Neraca Konsumsi',
            'description' => 'Responsible for developing software solutions.',
        ]);
        Division::create([
            'name' => 'Industri, Pertanian dan PEK',
            'description' => 'Responsible for developing software solutions.',
        ]);

        Division::create([
            'name' => 'Diseminasi, Pengolahan Data dan Jaringan',
            'description' => 'Responsible for developing software solutions.',
        ]);

        
}
}
