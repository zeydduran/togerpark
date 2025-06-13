<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Whitelist extends Model
{
    protected $fillable = [
        'company_id',
        'plate',
        'note',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
