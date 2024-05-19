<?php

namespace App\Http\Controllers\Data\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;

use App\Models\Client;

class ClientBookingsDataController extends Controller
{
     /**
     * Display a list of bookings for a client.
     *
     * @param Client $client The client whose bookings should be retrieved.
     * @return JsonResponse
     */
    public function index(Client $client): JsonResponse
    {
        Gate::authorize('manage-client', $client);

        $query = $client->bookings();

        switch (request()->when) {
            case 'past':
                $query->where('start', '<', now());
                break;
            case 'future':
                $query->where('start', '>', now());
                break;
        }

        $query->orderBy('start', 'ASC');

        return response()->json($query->get());
    }
}
