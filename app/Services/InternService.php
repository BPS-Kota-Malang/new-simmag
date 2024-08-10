<?php

namespace App\Services;

use App\Models\Intern;
use Illuminate\Support\Facades\Auth;

class InternService
{
    public function getAllIntern()
    {
        // Fetch data from the database
        return Intern::all();
    }

    public function getAllActiveInterns()
    {
        // Fetch data from the database
        return Intern::where('work_status', 'accepted')->get();
    }

    /**
     * Get Auth Intern
     */
    public function getAuthIntern()
    {
        $internId = Auth::user()->intern->id;
        
        // Fetch data from the database
        return Intern::where('id', $internId)->first();
        // return $internId;
    }
}
