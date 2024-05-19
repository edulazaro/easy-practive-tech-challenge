<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;

use App\Models\Journal;

class JournalsDataController extends Controller
{
    /**
     * Delete a journal entry.
     *
     * @param  Journal  $journal  The journal entry to  delete.
     */
    public function destroy(Journal $journal): JsonResponse
    {
        abort(400, 'asdas dsa');
        Gate::authorize('manage-client', $journal->client);

        $journal->delete();

        return response()->json([
            'success' => true,
            'message' => 'The Journal was successfully deleted',
        ], 200);
    }
}
