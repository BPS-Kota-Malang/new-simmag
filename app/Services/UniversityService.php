<?php

namespace App\Services;

use App\Models\University;

class UniversityService
{
    public function getUniversities()
    {
        // Fetch data from the database
        return University::all()->pluck('name');
    }
}
