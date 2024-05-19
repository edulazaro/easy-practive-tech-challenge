<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /** @var array Attributes appended to the model array and JSON. */
    protected $appends = [
        'formatted_date',
    ];

    /** @var array The attributes that are mass assignable. */
    protected $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

    /** @var array The attributes that should be casted. */
    protected $casts = [
        'start' => 'datetime:Y-m-d H:i:s',
        'end' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the formatted start and end dates.
     */
    public function getFormattedDateAttribute(): string
    {
        $startDate = new Carbon($this->attributes['start']);
        $endDate = new Carbon($this->attributes['end']);

        $startDateFormatted = $startDate->format('l d F Y, H:i');

        if ($startDate->isSameDay($endDate)) {
            return $startDateFormatted.' to '.$endDate->format('H:i');
        }

        return $startDateFormatted.' to '.$endDate->format('l d F Y, H:i');
    }

    /**
     * Get the client associated with the booking.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
