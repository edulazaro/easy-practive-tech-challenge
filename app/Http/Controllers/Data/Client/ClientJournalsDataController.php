<?php

namespace App\Http\Controllers\Data\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;

use App\Models\Client;
use App\Models\Journal;

class ClientJournalsDataController extends Controller
{
    /**
     * Show a list of journals for a client.
     *
     * @param Client $client The client whose journals should be retrieved.
     * @return JsonResponse
     */
    public function index(Client $client): JsonResponse
    {
        Gate::authorize('manage-client', $client);

        $query = $client->journals();

        return response()->json($query->get());
    }

    /**
     * Stores a new journal entry for a client.
     *
     * @param Client $client The client for whom the journal is created.
     * @return JsonResponse
     */
    public function store(Client $client): JsonResponse
    {
        Gate::authorize('manage-client', $client);

        $this->validate(request(), [
            'date' => 'required|date_format:Y-m-d',
            'content' => 'required',
        ]);

        $journal = new Journal;
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
