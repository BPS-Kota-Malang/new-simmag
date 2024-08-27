<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Http\Requests\StoreLogbookRequest;
use App\Http\Requests\UpdateLogbookRequest;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('logbook.index');
    }

    public function getLogbookList(Request $request)
    {
        // dd($request);
        $start = date('Y-m-d', strtotime($request->start));
        $end = date('Y-m-d', strtotime($request->end));

        $logbooks = Logbook::whereBetween('date', [$start, $end])
                        ->where('intern_id', Auth::user()->intern->id)
                        ->get();
        
        // Format the logbooks for FullCalendar
        $events = $logbooks->map(function ($logbook) {
            return [
                'id' => $logbook->id,
                'title' => $logbook->activity->name,
                'start' => $logbook->date . 'T' . $logbook->time_start,
                'end' => $logbook->date . 'T' . $logbook->time_end,
                'detail' => $logbook->detail,
                'backgroundColor' => $this->getEventColor($logbook), // Dynamic color
                'borderColor' => $this->getEventColor($logbook),
                'textColor' => '#ffffff',
                'allDay' => false, // Optional: set text color
            ];
        });

        return response()->json($events);
    }

    private function getEventColor($logbook)
    {
        // Example logic to determine color based on logbook data
        switch ($logbook->division_id) {
            case 1:
                return '#4A5568'; // Tailwind gray-700
            case 2:
                return '#3182CE'; // Tailwind blue-600
            case 3:
                return '#38B2AC'; // Tailwind teal-500
            case 4:
                return '#ECC94B'; // Tailwind yellow-400
            case 5:
                return '#F56565'; // Tailwind red-500
            case 6:
                return '#9F7AEA'; // Tailwind purple-500
            default:
                return '#2B6CB0'; // Tailwind blue-700
            }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {   
        $divisions = Division::all();
        $date = $request->input('date');
        return view('logbook.modal', compact('date', 'divisions'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $intern_id = Auth::user()->intern->id;
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'division_id' => 'required',
            'activity_id' => 'required',
            'detail' => 'required|string',
            'time_start' => 'required',
            'time_end' => 'required',
        ]);

        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $formatedDate = Carbon::parse($request->date)->format('Y-m-d');
        // Create a new logbook entry
        $logbook = new Logbook();
        $logbook->intern_id = $intern_id;
        $logbook->division_id = $request->division_id;
        $logbook->activity_id = $request->activity_id;
        $logbook->detail = $request->detail;
        $logbook->date = $formatedDate;
        $logbook->time_start = $request->time_start;
        $logbook->time_end = $request->time_end;
        $logbook->completed = $request->is_completed;
        $logbook->save();

        return response()->json([
            'success' => 'Logbook entry saved successfully!',
        ]);   //
    }

    /**
     * Display the specified resource.
     */
    public function show(Logbook $logbook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(logbook $logbook)
    {
        // dd($logbook);
        $logbook = $logbook;
        $divisions = Division::all();
        return view('logbook.modal', compact( 'divisions', 'logbook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logbook $logbook)
    {
        // Authorization check (ensure the user is authorized to update this logbook entry)
    $this->authorize('update', $logbook);
        
    // Validate the incoming request
    $validated = $request->validate([
        'date' => 'required|date',
        'division_id' => 'required|exists:divisions,id',
        'activity_id' => 'required|exists:activities,id',
        'detail' => 'nullable|string',
        'time_start' => 'required|date_format:H:i',
        'time_end' => 'required|date_format:H:i|after:time_start',
        'is_completed' => 'required|boolean',
    ]);

    // Update the logbook entry with the validated data
    $logbook->update($validated);

    // Return a JSON response for success
    return response()->json([
        'success' => true,
        'message' => 'Logbook entry updated successfully!',
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logbook $logbook)
    {
        //
    }
}
