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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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

    public function getInternAttendanceData()
    {
        $start_date = '2024-01-01';
        $end_date = Carbon::now()->format('Y-m-d');
        // $activeAttendances = $this->attendanceService-getAttendancesForDateRange($start_date, $end_date);
        $attendances = $this->attendanceService->getAllAttendancesForDateRange($start_date, $end_date);
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

                // $attendance->workhours = $getworkhours; // This will call the accessor
                $status = $this->attendanceService->getStatusAttendance($earliestCheckIn);
                $attendance->status = $status;
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
        $interns = $this->internService->getAllActiveInterns();

        return view('attendance.report')->with(compact('interns'));
        // return view('attendance.report-maintenance');
    }

    public function exportAttendance(Request $request)
    {   
        $intern = $this->internService->getAuthIntern();
        // dd($intern);
        $start_date =  $request->start_date;
        $end_date = $request->end_date;

        $attendances = Attendance::where('intern_id', $intern->id)
                            ->whereBetween('date', [Carbon::parse($start_date), Carbon::parse($end_date)])
                            ->get();
        
        $pdf = Pdf::loadView('attendance.layout-attendance', compact('intern', 'attendances', 'start_date', 'end_date'));
        
        $pdf_filename = 'attendance_report'.'_'.$start_date.'-'.$end_date.'_'.$intern->name.'.pdf';
        // $pdfPath = 'attendance_reports/attendance_report_' . $intern->name . time() . '.pdf';

        // $fullPath = public_path($pdfPath);
        // Storage::put($fullPath, $pdf->output());

        // return redirect(Storage::url($pdfPath));

        /**
         *  Option #1 Return Download PDF
         **/    
        // return $pdf->download('attendance_report.pdf');

        /**
         *  Option #2 Serve the PDF as an inline response
         * */
        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $pdf_filename . '"');
    }
}
