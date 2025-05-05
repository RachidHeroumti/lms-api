<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{

    public function buyCourse(Request $request)
    {

        $validated = $request->validate([
            'cource_id' => 'required|integer|exists:cources,id',
            'student_id' => 'required|integer|exists:users,id',
            'price' => 'required|numeric', 
        ]);
    
        $existingSubscription = Subscribe::where('cource_id', $validated['cource_id'])
                                          ->where('student_id', $validated['student_id'])
                                          ->first();
    
        if ($existingSubscription) {
            return response()->json([
                'message' => 'You are already subscribed to this course.',
            ], 400); 
        }
    
        
        $subscription = Subscribe::create([
            'cource_id' => $validated['cource_id'],
            'student_id' => $validated['student_id'],
            'price' => $validated['price'],
        ]);
    
        return response()->json([
            'message' => 'Course purchased successfully',
            'subscription' => $subscription
        ], 201); 
    }
    

    public function getStudentCourses($studentId)
    {
        $subscriptions = Subscribe::with('cource')->where('student_id', $studentId)->get();

        return response()->json($subscriptions);
    }

    public function getCourseSubscribers($courceId)
    {
        $subscriptions = Subscribe::with('student')->where('cource_id', $courceId)->get();

        return response()->json($subscriptions);
    }
}
