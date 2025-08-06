<?php

namespace App\Http\Controllers\API\Review;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Get all reviews

    public function index()
    {
        try {
            // Retrieve all reviews with the related user
            $reviews = PlanReview::with('user:id,name,avatar') // Get user information (name, avatar)
                ->select('plan_id', 'rating', 'review', 'user_id', 'created_at')
                ->latest()
                ->get();
    
            // Calculate average rating for each plan
            $plans = $reviews->groupBy('plan_id')->map(function ($planReviews) {
                // Calculate average rating for the plan
                $averageRating = $planReviews->avg('rating');
                
                // Add the average rating to each review for the corresponding plan
                $planReviews->each(function ($review) use ($averageRating) {
                    $review->average_rating = round($averageRating, 2); // Round off the average rating to 2 decimal places
                });
    
                return $planReviews;
            });
    
            // Return response with reviews and average rating
            return Helper::jsonResponse(true, 'All reviews retrieved successfully', 200, $plans->flatten()); // Flatten the collection to return a flat array
    
        } catch (\Exception $exception) {
            // Catch and handle any errors
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }
    






    // Store or Update a Review
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'rating'  => 'required|integer|min:1|max:5',
            'review'  => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = auth()->id();

        try {
            // Update or Create Review
            $review = PlanReview::updateOrCreate(
                ['user_id' => auth()->id(), 'plan_id' => $validated['plan_id']],
                $validated
            );

            return Helper::jsonResponse(true, 'Review saved successfully', 200, $review);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }

    // Get Average Rating
    public function averageRating()
    {
        $plans = Plan::withAvg('reviews', 'rating')->get();

        $plansWithAvgRating = $plans->map(function ($plan) {
            return [
                'plan_id' => $plan->id,
                'plan_type' => $plan->type,
                'average_rating' => round($plan->reviews_avg_rating, 2) ?? 0, // If no reviews, set to 0
            ];
        });

        return Helper::jsonResponse(true, 'All plans with average ratings retrieved successfully', 200, [
            'plans' => $plansWithAvgRating,
        ]);
    }
}
