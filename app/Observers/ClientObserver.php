<?php

namespace App\Observers;

use App\Models\Client;

class ClientObserver
{
    /*
    * Handle the Client "deleting" event.
    */
    public function deleting(Client $client): void
    {
        $client->bookings()->delete();
        $client->journals()->delete();
    }
}
