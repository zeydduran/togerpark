<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParkSession extends Model
{
    protected $fillable = [
        'company_id',
        'plate',
        'entry_time',
        'exit_time',
        'fee',
        'status',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
