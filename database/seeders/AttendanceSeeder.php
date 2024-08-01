<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Intern;
use Illuminate\Support\Carbon;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $interns = Intern::all();

        // Define the range of dates for the current month and the previous month
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Generate attendances for the previous month
        $this->generateAttendances($interns, $previousMonthStart, $previousMonthEnd);

        // Generate attendances for the current month
        $this->generateAttendances($interns, $currentMonthStart, $currentMonthEnd);
    }

    private function generateAttendances($interns, $startDate, $endDate)
    {
        foreach ($interns as $intern) {
            $date = $startDate->copy();
            while ($date <= $endDate) {
                Attendance::create([
                    'intern_id' => $intern->id,
                    'date' => $date->format('Y-m-d'),
                    'check_in' => $this->randomCheckInTime(),
                    'check_out' => $this->randomCheckOutTime(),
                    'status' => $this->randomStatus(),
                    'work_location' => $this->randomWorkLocation(),
                ]);
                $date->addDay();
            }
        }
    }

    private function randomCheckInTime()
    {
        // Randomly return a check-in time between 8:00 AM and 9:00 AM, or null
        return rand(0, 1) ? Carbon::createFromTime(rand(8, 9), rand(0, 59))->format('H:i:s') : null;
    }

    private function randomCheckOutTime()
    {
        // Randomly return a check-out time between 4:00 PM and 6:00 PM, or null
        return rand(0, 1) ? Carbon::createFromTime(rand(16, 18), rand(0, 59))->format('H:i:s') : null;
    }

    private function randomStatus()
    {
        $statuses = ['present', 'late', 'leave early', 'absent'];
        return $statuses[array_rand($statuses)];
    }

    private function randomWorkLocation()
    {
        $locations = ['office', 'home'];
        return $locations[array_rand($locations)];
    }
}
