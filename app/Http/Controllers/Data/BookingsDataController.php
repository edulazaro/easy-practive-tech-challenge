<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use App\Models\Booking;

class BookingsDataController extends Controller
{
    public function destroy(Booking $booking)
    {
        Gate::authorize('manage-client', $booking->client);

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'The Booking was successfully deleted',
        ], 200);
    }
}
