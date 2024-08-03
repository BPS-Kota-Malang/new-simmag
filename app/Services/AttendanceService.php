<?php

namespace App\Services;

use App\Models\Attendance;
use App\Services\InternService;
use Illuminate\Support\Carbon;

class AttendanceService
{
    protected $internService;

    public function __construct(InternService $internService)
    {
        $this->internService = $internService;
    }

    public function getAllAttendances()
    {
        // Fetch data from the database
        return Attendance::all();
    }

     /**
     * Attendance all active user on All Date Range
     */

    public function getAttendancesForActiveInterns()
    {
        $activeInterns = $this->internService->getAllActiveInterns();
        return Attendance::whereIn('intern_id', $activeInterns->pluck('id'))->get();
    }

     /**
     * Attendance 1 user on Date Range
     */

    public function getAttendancesForDate($id, $date)
    {
        return Attendance::where('intern_id', $id)
                    ->whereDate('date', $date)
                    ->first();
    }

    /**
     * Attendance all active user between Date Range
     */
    public function getAllAttendancesForDateRange($start_date, $end_date)
    {
        $activeInterns = $this->internService->getAllActiveInterns();
        
        return Attendance::whereIn('intern_id', $activeInterns->pluck('id'))
        ->whereBetween('date', [Carbon::parse($start_date), Carbon::parse($end_date)])
        ->get();
    }

    /**
     * Attendance 1 user between Date Range
     */
    public function getAttendancesForDateRange($id, $start_date, $end_date)
    {
        return Attendance::where('intern_id', $id)
                            ->whereBetween('date', [Carbon::parse($start_date), Carbon::parse($end_date)])
                            ->get();
    }


    /**
     * Make New Attendance Location for 1 user
     */
    public function makeAttendanceLocation ($id, $date, $workLocation)
    {
        Attendance::updateOrCreate(
            [
                'intern_id' => $id,
                'date' => Carbon::parse($date)->format('Y-m-d'),
            ],
            [
                'work_location' => $workLocation,
            ]
        );
    }
}
