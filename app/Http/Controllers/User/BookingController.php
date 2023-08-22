<?php

namespace App\Http\Controllers\User;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Requests\StoreBookingRequest;

class BookingController extends Controller
{
    public function index()
    {
        $this->authorize('bookings-manage');

        // Will implement booking management later
        //return response()->json(['success' => true]);
        $bookings = auth()->user()->bookings()
            ->with('apartment.property')
            ->withTrashed()
            ->orderBy('start_date')
            ->get();
 
        return BookingResource::collection($bookings);
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = auth()->user()->bookings()->create($request->validated());

        return new BookingResource($booking);
    }

    public function show(Booking $booking)
    {
        $this->authorize('bookings-manage');
 
        if ($booking->user_id != auth()->id()) {
            abort(403);
        }
 
        return new BookingResource($booking);
    }
 
    public function destroy(Booking $booking)
    {
        $this->authorize('bookings-manage');
 
        if ($booking->user_id != auth()->id()) {
            abort(403);
        }
 
        $booking->delete();
 
        return response()->noContent();
    }
}
