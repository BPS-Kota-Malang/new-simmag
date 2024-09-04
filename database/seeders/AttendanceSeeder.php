<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use Carbon\Carbon;
use Faker\Factory as Faker;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $internIds = [1, 4];

        // Define the start and end dates for the four months
        $startDate = Carbon::createFromDate(2023, 5, 1);
        $endDate = Carbon::createFromDate(2023, 8, 31);

        // Loop through each intern
        foreach ($internIds as $internId) {
            $date = $startDate->copy();

            // Loop through each date in the range
            while ($date->lte($endDate)) {
                // Only generate attendance for weekdays (Monday to Friday)
                if ($date->isWeekday()) {
                    $checkIn = $faker->optional(0.9, null)->time('H:i:s');
                    $checkOut = $checkIn ? Carbon::createFromTimeString($checkIn)->addHours($faker->numberBetween(6, 8))->format('H:i:s') : null;

                    Attendance::create([
                        'intern_id' => $internId,
                        'date' => $date->format('Y-m-d'),
                        'check_in' => $checkIn,
                        'check_out' => $checkOut,
                        'workhours' => $checkIn && $checkOut ? Carbon::parse($checkIn)->diffInHours($checkOut) : null,
                        'status' => $checkIn ? $faker->randomElement(['present', 'late', 'leave early']) : $faker->randomElement(['absent', 'sick', 'leave']),
                        'work_location' => $faker->randomElement(['office', 'home']),
                        'latitude_in' => $checkIn ? $faker->latitude : null,
                        'longitude_in' => $checkIn ? $faker->longitude : null,
                        'latitude_out' => $checkOut ? $faker->latitude : null,
                        'longitude_out' => $checkOut ? $faker->longitude : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $date->addDay(); // Move to the next day
            }
        }
    }
   
    public function rollback()
    {
        // Delete all records that were seeded
        Attendance::where('created_at', '>=', now()->subMinutes(10))->delete();
        // Adjust the time window to match when you ran the seeder
    }
}
