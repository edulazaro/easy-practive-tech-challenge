<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    /** @var array The attributes that are mass assignable. */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
    ];

    /**
     * Bookings associated with the client.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Journals associated with the client.
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }
}
