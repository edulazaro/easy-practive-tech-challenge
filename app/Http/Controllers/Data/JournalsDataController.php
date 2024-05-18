<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use App\Models\Journal;

class JournalsDataController extends Controller
{
    public function destroy(Journal $journal)
    {
        Gate::authorize('manage-client', $journal->client);

        $journal->delete();

        return response()->json([
            'success' => true,
            'message' => 'The Journal was successfully deleted',
        ], 200);
    }
}
