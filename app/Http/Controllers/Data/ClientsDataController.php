<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use App\Models\Client;

class ClientsDataController extends Controller
{
    public function destroy(Client $client)
    {
        Gate::authorize('manage-client', $client);

        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'The Journal was successfully deleted',
        ], 200);
    }
}
