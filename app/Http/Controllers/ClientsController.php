<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ClientsController extends Controller
{
    /**
     * Display a list of clients.
     */
    public function index(): View
    {
        $clients = Client::where('user_id', auth()->user()->id)
            ->withCount('bookings')->get();

        return view('clients.index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new client.
     */
    public function create(): View
    {
        return view('clients.create');
    }

    /**
     * Display the specified client.
     *
     * @param  Client  $client  The client to show.
     */
    public function show(Client $client): View
    {
        Gate::authorize('manage-client', $client);

        $client->load([
            'bookings' => function ($query) {
                $query->orderBy('start', 'ASC');
            },
            'journals' => function ($query) {
                $query->orderBy('date', 'ASC');
            },
        ]);

        return view('clients.show', ['client' => $client]);
    }
}
