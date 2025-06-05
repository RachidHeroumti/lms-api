<?php

namespace App\Http\Controllers;

use App\Models\Cource;
use App\Models\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{

    public function buyCourse(Request $request)
    {

        $validated = $request->validate([
            'cource_id' => 'required|integer|exists:cources,id',
            'price' => 'required|numeric', 
        ]);
    
        $existingSubscription = Subscribe::where('cource_id', $validated['cource_id'])
                                          ->where('student_id',$request->user()->id)
                                          ->first();
    
        if ($existingSubscription) {
            return response()->json([
                'message' => 'You are already subscribed to this course.',
            ], 200); 
        }
    
        
        $subscription = Subscribe::create([
            'cource_id' => $validated['cource_id'],
            'student_id' => $request->user()->id, 
            'price' => $validated['price'],
        ]);
    
        return response()->json([
            'message' => 'Course purchased successfully',
            'subscription' => $subscription
        ], 201); 
    }
    

    public function getStudentCourses($studentId)
    {
        $subscriptions = Subscribe::with('cource')->where('student_id', $studentId)->
        where('accepted',true)->get();

        return response()->json(['subscriptions'=>$subscriptions]);
    }

    public function getCourseSubscribers($courceId)
    {
      $subscriptions = Subscribe::with(['student', 'cource'])
    ->where('cource_id', $courceId)
    ->get();

        return response()->json([ 'subscriptions' => $subscriptions]);
    }

public function getAnalytics($courceId) 
{
    $course = Cource::withCount(['subscriptions' => function ($query) {
        $query->where('accepted', true);
    }])->find($courceId);

    if (!$course) {
        return response()->json(['message' => 'Course not found'], 404);
    }

    return response()->json([
        'analytics' => [
            'id' => $course->id,
            'courseId' => $course->id,
            'title' => $course->title,
            'studentsSubscribed' => $course->subscriptions_count, 
        ]
    ]);
}


public function PendingOrder()
{
    $ordersPending = Subscribe::with(['student', 'cource'])
        ->where('accepted', false)
        ->get();

    return response()->json(['orderPending' => $ordersPending]);
}

public function acceptPendingOrder($subscriptionId)
{
    $subscription = Subscribe::where('id', $subscriptionId)
        ->where('accepted', false)
        ->first();
    if (!$subscription) {
        return response()->json(['message' => 'Subscription not found or already accepted'], 404);
    }
    $subscription->accepted = true;
    $subscription->save();
    return response()->json(['message' => 'Subscription accepted successfully', 'subscription' => $subscription]);
}

public function deleteSubscription($id)
{
    $subscription = Subscribe::find($id);

    if (!$subscription) {
        return response()->json(['message' => 'Subscription not found'], 200);
    }

    $subscription->delete();

    return response()->json(['message' => 'Subscription deleted successfully']);
}




}
