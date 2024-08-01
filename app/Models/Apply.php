<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Apply extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id', 'start_date_apply', 'end_date_apply', 'start_date_answer', 'end_date_answer'
    ];



    public function intern() : BelongsTo
    {
        return $this->belongsTo(Intern::class);
    }

}
