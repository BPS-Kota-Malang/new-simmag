<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed 10 records
        for ($i = 0; $i < 10; $i++) {
            Activity::create([
                'name' => fake()->word(),
                'division_id' => Division::inRandomOrder()->first()->id,
            ]);
        }
    }
}
