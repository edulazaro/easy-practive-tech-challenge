<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class JournalsDataController extends Controller
{
    /**
     * Delete a journal entry.
     *
     * @param  Journal  $journal  The journal entry to  delete.
     */
    public function destroy(Journal $journal): JsonResponse
    {
        Gate::authorize('manage-client', $journal->client);

        $journal->delete();

        return response()->json([
            'success' => true,
            'message' => 'The Journal was successfully deleted',
        ], 200);
    }
}
