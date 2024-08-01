<?php

namespace App\Http\Controllers;

use App\Models\Apply;
use App\Models\Intern;
use App\Http\Requests\StoreApplyRequest;
use App\Http\Requests\UpdateApplyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applies = Apply::all();

        return view('apply.index')
            ->with('applies', $applies);
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
    public function store(StoreApplyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Apply $apply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apply $apply)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $apply)
    {   
        $apply = Apply::find($apply);

                // Validate incoming request data if necessary
        $validatedData = $request->validate([
            'start_date_answer' => 'required|date',
            'end_date_answer' => 'required|date',
        ]);

        // dd($validatedData);

        $apply->update($validatedData);

        return redirect()->route('apply.index')->with('success', 'Apply updated successfully!');
    }


    // public function answerDate ($start_date_answer, $end_date_answer)
    // {

    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apply $apply)
    {
        //
    }

    public function answerDate( $id)
    {
        $apply = Apply::find($id);
        
        return $apply;
    }

    public function accepted (Request $request)
    {
        $intern = Intern::find($request->id);
        
        // return $intern;
        $intern->update(
            [
                'work_status' => 'accepted'
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Status updated successfully!');
        
    }

    public function rejected (Request $request)
    {
        $intern = Intern::find($request->id);
        
        $intern->update(
            [
                'work_status' => 'rejected'
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Status updated successfully!');

    }
}
