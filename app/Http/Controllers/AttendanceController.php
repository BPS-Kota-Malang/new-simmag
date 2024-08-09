<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Intern;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\InternService;
use App\Services\AttendanceService;

class AttendanceController extends Controller
{
    /**
     * INject Service
     */
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
        $internId = Auth::user()->intern->id;
        $attendances = Attendance::all();

        // Get today's date
        $today = Carbon::today()->format('Y-m-d');
        $todayAttendance = $this->attendanceService->getAttendancesForDate($internId, $today);
        // Retrieve today's attendance records
        // $todayAttendance = Attendance::where('intern_id', $internId)
        //                             ->whereDate('date', $today)
        //                             ->first();

        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
        // $monthAttendance = $this->attendanceService->getAttendancesForDateRange($internId, $today);
        $monthAttendance = Attendance::where('intern_id', $internId)
                             ->whereBetween('date', [$startOfMonth, $endOfMonth])
                             ->get();

        return view('attendance.index')
            ->with('attendances', $monthAttendance)
            ->with('todayAttendance', $todayAttendance);
    }

    public function markAttendance(Request $request)
    {   
        $request->validate([
            'intern_id' => 'required|integer',
            'latitude' => 'nullable|numeric|min:-90|max:90',
            'longitude' => 'nullable|numeric|min:-180|max:180',
            'work_location' => 'required|in:office,home', // Adjust based on your needs
        ]);
    
        $internId = $request->input('intern_id');
        $now = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $workLocation = $request->input('work_location');
    
        // Retrieve today's attendance record for the specified intern
        $attendance = Attendance::where('intern_id', $internId)
                                ->whereDate('date', $now)
                                ->first();

        /**
         * Check today attendance Record
         */
        if (!$attendance)
        {
            $this->attendanceService->makeAttendanceLocation($internId, $date = $now, $workLocation = 'office');
        } else {
            /**
             * Updating Checkin
             */
            if (!$attendance->check_in) {
                $attendance->check_in = $currentTime;
                $attendance->latitude_in = $latitude;
                $attendance->longitude_in = $longitude;
                $attendance->save();
                // return response()->json(['message' => 'Checked in']);
                return redirect()->back()->with(['message' => 'Checked in']);
            }

            // If there's already a record, determine if we need to check-in or check-out
            if (!$attendance->check_out) {
                // Check-out if check-in exists and check-out does not
                $attendance->check_out = $currentTime;
                $attendance->latitude_out = $latitude;
                $attendance->longitude_out = $longitude;
                $attendance->save();
                // return response()->json(['message' => 'Checked out']);
                return redirect()->back()->with(['message' => 'Checked Out']);
            } else {
                // Multiple button presses scenario: handle updating existing check-in/check-out times
                $checkIns = Attendance::where('intern_id', $internId)
                                    ->whereDate('date', $now)
                                    ->whereNotNull('check_in')
                                    ->pluck('check_in')
                                    ->toArray();

                $checkOuts = Attendance::where('intern_id', $internId)
                                    ->whereDate('date', $now)
                                    ->whereNotNull('check_out')
                                    ->pluck('check_out')
                                    ->toArray();

                $earliestCheckIn = min($checkIns);
                $latestCheckOut = max(array_merge($checkOuts, [$currentTime]));

                $attendance->check_in = $earliestCheckIn;
                $attendance->check_out = $latestCheckOut;
                $attendance->latitude_out = $latitude;
                $attendance->longitude_out = $longitude;

                $workhours = $attendance->workhours; // This will call the accessor
                $attendance->save();
                // return response()->json(['message' => 'Updated attendance']);
                return redirect()->back()->with(['message' => 'Checked in']);
                }
        }
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
    public function store(StoreAttendanceRequest $request)
    {
        $request->validate([
            'intern_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status' => 'required|string',
            'work_location' => 'required|string|in:home,office',
        ]);

        Attendance::create($request->all());

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function reportAttendancePage()
    {
        return view('attendance.report');
    }
}
