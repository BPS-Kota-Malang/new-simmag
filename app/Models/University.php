<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        
    ];

    public function intern() : BelongsTo
    {
        return $this->belongsTo(Intern::class);
    }
}
