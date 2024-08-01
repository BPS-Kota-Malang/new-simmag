<?php

namespace App\Services;

use App\Models\Intern;

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
}
