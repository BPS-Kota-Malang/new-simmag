<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\UpdateDivisionRequest;
use App\Models\Logbook;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'intern_id' => 'required|exists:interns,id',
            'division_id' => 'required|exists:divisions,id',
            'detail' => 'required|string',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create a new logbook entry
        $logbook = new Logbook();
        $logbook->intern_id = $request->intern_id;
        $logbook->division_id = $request->division_id;
        $logbook->detail = $request->detail;
        $logbook->date = $request->date;
        $logbook->time_start = $request->time_start;
        $logbook->time_end = $request->time_end;
        $logbook->save();

        return response()->json([
            'success' => 'Logbook entry saved successfully!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDivisionRequest $request, Division $division)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        //
    }
}
