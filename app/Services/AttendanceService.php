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

    public function getAttendancesForActiveInterns()
    {
        $activeInterns = $this->internService->getAllActiveInterns();
        return Attendance::whereIn('intern_id', $activeInterns->pluck('id'))->get();
    }

    public function getAttendancesForDateRange($start_date, $end_date)
    {
        $activeInterns = $this->internService->getAllActiveInterns();
        
        return Attendance::whereIn('intern_id', $activeInterns->pluck('id'))
        ->whereBetween('date', [Carbon::parse($start_date), Carbon::parse($end_date)])
        ->get();
    }
}
