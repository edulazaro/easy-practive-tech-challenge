<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class BookingsDataController extends Controller
{
    /**
     * Delete a booking.
     *
     * @param  Booking  $booking  The booking to delete.
     */
    public function destroy(Booking $booking): JsonResponse
    {
        Gate::authorize('manage-client', $booking->client);

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'The Booking was successfully deleted',
        ], 200);
    }
}
