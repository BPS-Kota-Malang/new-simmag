<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Intern extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'name',
        'university',
        'faculty',
        'courses',
        'phone',
        'file_proposal',
        'file_suratpengantar',
        'start_date',
        'end_date',
        'user_id',
        'work_status',
    ];

    public function apply() : HasMany
    {
        return $this->hasMany(Apply::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendance() : HasMany
    {
        return $this->hasMany(Attendance::class);
    }


}
