<?php

namespace App\Http\Controllers\Data\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Gate;

class ClientBookingsDataController extends Controller
{
    public function index(Client $client)
    {
        Gate::authorize('manage-client', $client);

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
