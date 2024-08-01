<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intern;
use App\Http\Requests\StoreInternRequest;
use App\Http\Requests\UpdateInternRequest;
use App\Models\Attendance;
use App\Services\InternService;
use App\Services\AttendanceService;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class AdminAttendanceController extends Controller
{   
    protected $internService;
    protected $attendanceService;

    public function __construct(InternService $internService, AttendanceService $attendanceService)
    {
        $this->internService = $internService;
        $this->attendanceService = $attendanceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $start_date = '2024-01-01';
        // $end_date = Carbon::now()->format('Y-m-d');
        // $activeAttendances = $this->attendanceService-getAttendancesForDateRange($start_date, $end_date);
        // $attendances = $this->attendanceService->getAttendancesForActiveInterns($start_date, $end_date);

        // return view('superadmin.attendance')->with('activeAttendances', $attendances);
        return view('superadmin.attendance');
    }

    public function getData()
    {
        $start_date = '2024-01-01';
        $end_date = Carbon::now()->format('Y-m-d');
        // $activeAttendances = $this->attendanceService-getAttendancesForDateRange($start_date, $end_date);
        $attendances = $this->attendanceService->getAttendancesForDateRange($start_date, $end_date);
        // $attendances = Attendance::all();
        // dd($attendances);
        // return $attendances->toJson();
        
        return DataTables::of($attendances)
        ->addColumn('intern_name', function($attendance) {
            return $attendance->intern->name;
        })
        ->addColumn('actions', function($attendance) {
            return '
                <a href="'.route('admin.attendance.edit', $attendance->id).'" class="text-blue-500 hover:text-blue-700">Edit</a>
                <form action="'.route('admin.attendance.destroy', $attendance->id).'" method="POST" class="inline-block ml-2">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                </form>';
        })
        ->rawColumns(['actions'])
        ->make(true);
        // ->toJson();
    }
    /**
     * Show Bulk form
     */
    public function showBulkSetWorkLocationForm()
    {
        $interns = Intern::all();
        return view('attendance.bulkSetWorkLocation', compact('interns'));
    }

    /**
     * 
     */
    public function bulkSetWorkLocation(Request $request)
    {
        $request->validate([
            'intern_ids' => 'required|array',
            'intern_ids.*' => 'exists:interns,id',
            'dates' => 'required|array',
            'dates.*' => 'date',
            'work_location' => 'required|in:office,home',
        ]);

        $internIds = $request->input('intern_ids');
        $dates = $request->input('dates');
        $workLocation = $request->input('work_location');

        foreach ($internIds as $internId) {
            foreach ($dates as $date) {
                Attendance::updateOrCreate(
                    [
                        'intern_id' => $internId,
                        'date' => Carbon::parse($date)->format('Y-m-d'),
                    ],
                    [
                        'work_location' => $workLocation,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Work locations updated successfully.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
