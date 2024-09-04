<?php

namespace App\Http\Controllers;

use App\Exports\InternAttendanceExport;
use Illuminate\Http\Request;
use App\Models\Intern;
use App\Http\Requests\StoreInternRequest;
use App\Http\Requests\UpdateInternRequest;
use App\Models\Attendance;
use App\Models\Division;
use App\Services\InternService;
use App\Services\AttendanceService;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

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
        $interns = $this->internService->getAllActiveInterns();
        $divisions = Division::all();
        return view('superadmin-attendance.index')
                ->with( 'divisions', $divisions)
                ->with ('interns', $interns);
    }
    
    public function getData(Request $request)
    {
      
        $attendances = $this->attendanceService->getFilteredAttendances($request->all());

       
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
                $this->attendanceService->makeAttendanceLocation($internId, $date, $workLocation);
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

    public function export(Request $request)
    {   
        $filters = $request->all();
        return Excel::download(new InternAttendanceExport($filters), 'intern_attendance.xlsx');
    }
}
