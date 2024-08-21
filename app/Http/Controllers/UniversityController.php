<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Http\Requests\StoreUniversityRequest;
use App\Http\Requests\UpdateUniversityRequest;
use App\Services\UniversityService;
use Illuminate\Http\Request;


class UniversityController extends Controller
{

protected $universityService;

    // Inject the service via the constructor
    public function __construct(UniversityService $universityService)
    {
        $this->universityService = $universityService;
    }

    public function search (Request $request)
    {
        $query = $request->input('query');
        $universities = University::where('name', 'LIKE', "%{$query}%")->get();
        return response()->json($universities);
    }

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
        $request->validate(['name' => 'required|string']);
        $university = University::create(['name' => $request->name]);
        return response()->json(['success' => true, 'item' => $university]);
    }

    /**
     * Display the specified resource.
     */
    public function show(University $university)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(University $university)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUniversityRequest $request, University $university)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(University $university)
    {
        //
    }
}
