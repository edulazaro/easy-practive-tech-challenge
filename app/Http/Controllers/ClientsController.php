<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Rules\PhoneRule;
use App\Rules\EmailWithTLDRule;

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

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:190',
            'email' => ['nullable', 'email', 'required_without:phone', new EmailWithTLDRule()],
            'phone' => ['nullable', 'required_without:email', new PhoneRule()],
        ]);

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
