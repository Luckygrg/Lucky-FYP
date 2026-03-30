<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Spa;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     * Only customers with a completed booking at the spa may submit.
     */
    public function store(Request $request, Spa $spa)
    {
        $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            'comment'    => ['nullable', 'string', 'max:1000'],
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Ensure the booking belongs to the authenticated customer and this spa
        if ($booking->user_id !== Auth::id() || $booking->spa_id !== $spa->id) {
            abort(403);
        }

        // Ensure the booking is completed
        if ($booking->status !== 'completed') {
            return back()->with('review_error', 'You can only review a spa after your booking is completed.');
        }

        // Ensure no duplicate review for this booking
        if ($booking->review()->exists()) {
            return back()->with('review_error', 'You have already submitted a review for this booking.');
        }

        Review::create([
            'user_id'    => Auth::id(),
            'spa_id'     => $spa->id,
            'booking_id' => $booking->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        // Recalculate spa rating and review count
        $this->recalculateSpaRating($spa);

        return back()->with('review_success', 'Your review has been submitted. Thank you!');
    }

    /**
     * Delete a review (only by the review owner).
     */
    public function destroy(Spa $spa, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        $this->recalculateSpaRating($spa);

        return back()->with('review_success', 'Your review has been removed.');
    }

    private function recalculateSpaRating(Spa $spa): void
    {
        $reviews = Review::where('spa_id', $spa->id);
        $count   = $reviews->count();
        $avg     = $count > 0 ? round($reviews->avg('rating'), 1) : 0;

        $spa->update([
            'review_count' => $count,
            'rating'       => $avg,
        ]);
    }
}
