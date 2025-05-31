<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function getAll()
    {
        $reviews = Review::all();
        return response()->json(['reviews' => $reviews]);
    }

 public function createReview(Request $request)
{
    $validated = $request->validate([
        'course_id' => 'required|integer',
        'content' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $review = Review::create([
        'user_id' => $request->user()->id,  
        'course_id' => $validated['course_id'],
        'content' => $validated['content'],
        'rating' => $validated['rating'],
    ]);

    return response()->json(['review' => $review], 201);
}


    public function getOne($id)
    {
        $review = Review::findOrFail($id);
        return response()->json(['review' => $review]);
    }

    public function getReviewByCource($id)
    {
        $reviews = Review::where('course_id', $id)->get();
        return response()->json(['reviews' => $reviews]);
    }

    public function updateReview(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->update($request->only(['content', 'rating']));

        return response()->json(['review' => $review]);
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
