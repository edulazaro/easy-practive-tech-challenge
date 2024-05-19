<?php

namespace App\Http\Controllers\Data\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Journal;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ClientJournalsDataController extends Controller
{
    /**
     * Show a list of journals for a client.
     *
     * @param  Client  $client  The client whose journals should be retrieved.
     */
    public function index(Client $client): JsonResponse
    {
        Gate::authorize('manage-client', $client);

        $collection = $client->journals()->orderBy('date', 'ASC')->get();

        return response()->json([
            'success' => true,
            'collection' => $collection,
        ]);
    }

    /**
     * Stores a new journal entry for a client.
     *
     * @param  Client  $client  The client for whom the journal is created.
     */
    public function store(Client $client): JsonResponse
    {
        Gate::authorize('manage-client', $client);

        $this->validate(request(), [
            'date' => 'required|date_format:Y-m-d',
            'content' => 'required',
        ]);

        $journal = new Journal();
        $journal->client_id = $client->id;
        $journal->date = request()->get('date');
        $journal->content = strip_tags(request()->get('content'));
        $journal->save();

        return response()->json([
            'success' => true,
            'message' => 'The journal was successfully created.',
            'data' => $journal,
        ], 201);
    }
}
