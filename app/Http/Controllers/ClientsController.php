<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\Gate;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::where('user_id', auth()->user()->id)->withCount('bookings')->get();

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        Gate::authorize('manage-client', $client);

        $client->load([
            'bookings' => function ($query) {
                $query->orderBy('start', 'ASC');
            },
            'journals' => function ($query) {
                $query->orderBy('date', 'ASC');
            }
        ]);

        return view('clients.show', ['client' => $client]);
    }
}
