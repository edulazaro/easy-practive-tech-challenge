<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $appends = [
        'formatted_date',
    ];

    protected $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

    protected $dates = [
        'start',
        'end',
    ];

    /**
     * Return the formatted booking time
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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
