<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Intern extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'name',
        'university_id',
        'faculty_id',
        'department_id',
        'phone',
        'sex',
        'photo',
        'file_proposal',
        'file_suratpengantar',
        'start_date',
        'end_date',
        'user_id',
        'division_id',
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

    public function university() : BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function faculty() : BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }   

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

}
