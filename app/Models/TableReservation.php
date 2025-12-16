<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TableReservation extends Model
{
    protected $fillable = [
        'number_of_guests',
        'reservation_date',
        'status',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'number_of_guests' => 'integer',
        'reservation_date' => 'datetime',
    ];

    /**
     * Get the user that owns this reservation
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
