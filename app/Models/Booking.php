<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    /** @var array<string>  Attributes appended to the model array and JSON. */
    protected array $appends = [
        'formatted_date',
    ];

    /** @var array<string> The attributes that are mass assignable. */
    protected array $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

     /** @var array<string> Attributes mutated to dates. */
    protected array $dates = [
        'start',
        'end',
    ];

    /**
     * Get the formatted start and end dates.
     *
     * @return string
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
     *
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
