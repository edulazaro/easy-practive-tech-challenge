<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    /** @var array<string> The attributes that are mass assignable. */
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
     *
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Journals associated with the client.
     *
     * @return HasMany
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }
}
