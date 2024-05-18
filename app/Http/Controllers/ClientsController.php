<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
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

        $client = $client->with(['bookings' => function ($query) {
            $query->orderBy('start', 'ASC');
        }])->first();

        return view('clients.show', ['client' => $client]);
    }

    public function store(Request $request)
    {
        $client = new Client;
        $client->user_id = auth()->user()->id;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        return $client;
    }

    public function destroy(Client $client)
    {
        Gate::authorize('manage-client', $client);

        $client->delete();

        return 'Deleted';
    }
}
