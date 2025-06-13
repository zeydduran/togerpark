<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentHistory extends Model
{
    protected $fillable = [
        'company_id',
        'park_session_id',
        'amount',
        'method',
        'paid_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function parkSession(): BelongsTo
    {
        return $this->belongsTo(ParkSession::class);
    }
}
