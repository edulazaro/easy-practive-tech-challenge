<?php

namespace App\Http\Controllers\Data\Client;

use App\Http\Controllers\Controller;

use App\Client;

class ClientBookingsDataController extends Controller
{
    public function index(Client $client)
    {
        $query = $client->bookings();

        switch (request()->filter) {
            case 'past':
                $query->where('start', '<', now());
                break;
            case 'future':
                $query->where('start', '>', now());
                break;
        }

        return response()->json($query->get());
    }
}
