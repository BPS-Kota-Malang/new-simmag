<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id',
        'division_id',
        'date',
        'time_start',
        'time_end',
        'detail',
    ];
}
