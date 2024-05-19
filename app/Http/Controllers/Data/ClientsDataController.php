<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Rules\EmailWithTLDRule;
use App\Rules\PhoneRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ClientsDataController extends Controller
{
    /**
     * Store a new client.
     *
     * @param  Request  $request  The request with the client data.
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|max:190',
            'email' => [
                'nullable',
                'email',
                'required_without:phone',
                new EmailWithTLDRule(),
            ],
            'phone' => ['nullable', 'required_without:email', new PhoneRule()],
        ]);

        $client = new Client();
        $client->user_id = auth()->user()->id;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        return response()->json([
            'success' => true,
            'message' => 'The client was successfully created.',
            'data' => $client,
        ], 201);
    }

    /**
     * Delete a client.
     *
     * @param  Client  $client  The client to  delete.
     */
    public function destroy(Client $client): JsonResponse
    {
        Gate::authorize('manage-client', $client);

        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'The Journal was successfully deleted.',
        ], 200);
    }
}
