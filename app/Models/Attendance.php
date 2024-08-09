<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Intern;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id', 
        'date', 
        'check_in', 
        'check_out', 
        'workhours', 
        'status', 
        'work_location',
        'latitude',
        'longitude',
    ];

    public function intern() : BelongsTo
    {
        return $this->belongsTo(Intern::class);
    }

//     public function getWorkhoursAttribute()
//     {
//         if ($this->check_in && $this->check_out) {
//             $checkIn = Carbon::parse($this->check_in);
//             $checkOut = Carbon::parse($this->check_out);
//             return $checkOut->diff($checkIn)->format('%H:%I:%S');
//         }

//         return null;
//     }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->check_in && $model->check_out) {
                $checkIn = Carbon::parse($model->check_in);
                $checkOut = Carbon::parse($model->check_out);
                $model->workhours = $checkOut->diff($checkIn)->format('%H:%I:%S');
            }
        });
    }
}
