<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;

use App\Models\Booking;

class BookingsDataController extends Controller
{
    /**
     * Delete a booking.
     *
     * @param Booking $booking The booking to delete.
     * @return JsonResponse
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
