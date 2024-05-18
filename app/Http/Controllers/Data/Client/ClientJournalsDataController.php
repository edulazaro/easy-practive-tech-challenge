<?php

namespace App\Http\Controllers\Data\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use App\Models\Client;
use App\Models\Journal;

class ClientJournalsDataController extends Controller
{
    public function index(Client $client)
    {
        Gate::authorize('manage-client', $client);

        $query = $client->journals();

        return response()->json($query->get());
    }

    public function store(Client $client)
    {
        Gate::authorize('manage-client', $client);

        $this->validate(request(), [
            'date' => 'required|date_format:Y-m-d',
            'content' => 'required',
        ]);

        $journal = new Journal;
        $journal->client_id = $client->id;
        $journal->date = request()->get('date');
        $journal->content = request()->get('content');
        $journal->save();

        return response()->json($journal);
    }
}
