<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Intern;
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
        $attendances = Attendance::where('intern_id', $id)
                            ->whereBetween('date', [Carbon::parse($start_date), Carbon::parse($end_date)])
                            ->get();
        return $attendances;
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

    /**
     * Make Status
     */
    public function getStatusAttendance ($checkin = null, $checkout = null)
    {   

        if ($checkin) {
            $checkinTime = Carbon::parse($checkin);
            $lateTime = Carbon::createFromTime(7, 30);
    
            if ($checkinTime->greaterThan($lateTime)) {
                return 'late';
            } else {
                return 'present';
            }
        }

        if ($checkout) {
            $checkoutTime = Carbon::parse($checkout);
            $lateTime = Carbon::createFromTime(15, 00);
    
            if ($lateTime->greaterThan($checkoutTime)) {
                return 'early leave';
            } else {
            return 'present';
            }
        }
    }

    public function getFilteredAttendances($filters)
    {
        $query = Attendance::query();

        // Filter by intern_id if provided
        if (isset($filters['intern_id']) && $filters['intern_id'] != '') {
            $query->where('intern_id', $filters['intern_id']);
        }
        // Filter by division if provided and intern_id is not set
        elseif (isset($filters['division']) && $filters['division'] != '') {
            $internIds = Intern::where('division_id', $filters['division'])->pluck('id');
            $query->whereIn('intern_id', $internIds);
        }
        // Filter by month if provided
        if (isset($filters['month']) && $filters['month'] != '') {
            $query->whereMonth('date', $filters['month']);
        }

        return $query->get(); // Use get() to retrieve results for DataTables processing
    }


}
