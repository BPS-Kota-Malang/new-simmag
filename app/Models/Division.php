<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Division extends Model
{
    use HasFactory, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function logbook() : BelongsTo
    {
        return $this->belongsTo(Logbook::class);
    }

    public function intern() : BelongsTo
    {
        return $this->belongsTo(Intern::class);
    }

    public function employee() : HasMany
    {
        return $this->hasMany(Employee::class);
    }


}
