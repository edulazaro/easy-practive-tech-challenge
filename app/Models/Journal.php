<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model
{
    use HasFactory;

    /** @var array Attributes appended to the model array and JSON. */
    protected $appends = [
        'formatted_date',
    ];

    /** @var array The attributes that should be casted. */
    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    /**
     * Get the client associated with the journal.
     *
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the formatted ate.
     */
    public function getFormattedDateAttribute(): string
    {
        if (empty($this->attributes['date'])) {
            return null;
        }

        $date = new Carbon($this->attributes['date']);

        return $date->format('l d F Y');
    }
}
