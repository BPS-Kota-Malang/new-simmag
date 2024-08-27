<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'activity_id',
        'status',
        'grade',
    ];

    public function activity() : BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
    
}
