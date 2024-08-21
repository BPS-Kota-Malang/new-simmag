<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Http\Request;


class UniversityService
{
    public function getAllActivity()
    {
        return Activity::all();
    }

}

