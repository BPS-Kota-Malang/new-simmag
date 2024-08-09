<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Search
     */
    public function search (Request $request)
    {
        // $this->universityService->searchUniversity($request);
        $query = $request->get('query');
        $universities = Faculty::where('name', 'LIKE', "%{$query}%")->get();
        return response()->json($universities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        $faculty = Faculty::create(['name' => $request->name]);
        return response()->json(['success' => true, 'item' => $faculty]);
    }
}
