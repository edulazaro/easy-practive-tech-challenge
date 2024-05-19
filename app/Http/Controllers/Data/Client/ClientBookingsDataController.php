<?php

namespace App\Http\Controllers\Data\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ClientBookingsDataController extends Controller
{
    /**
     * Display a list of bookings for a client.
     *
     * @param  Client  $client  The client whose bookings should be retrieved.
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

        $collection = $query->orderBy('start', 'ASC')->get();

        return response()->json([
            'success' => true,
            'collection' => $collection,
        ]);
    }

    /**
     * Stores a new booking entry for a client.
     *
     * @param  Client  $client  The client for whom the journal is created.
     */
    public function store(Client $client): JsonResponse
    {
        Gate::authorize('manage-client', $client);

        $this->validate(request(), [
            'start' => 'required|date_format:Y-m-d\TH:i',
            'end' => 'required|date_format:Y-m-d\TH:i|after:start',
            'notes' => 'nullable',
        ]);

        $booking = new Booking();
        $booking->client_id = $client->id;
        $booking->start = request()->get('start');
        $booking->end = request()->get('end');
        $booking->notes = strip_tags(request()->get('notes'));
        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'The booking was successfully created.',
            'data' => $booking,
        ], 201);
    }
}
