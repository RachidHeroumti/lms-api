<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.5', 
            'cource_id' => 'required|integer|exists:cources,id',
            'student_id' => 'required|integer|exists:users,id',
        ]);

        $amountInCents = intval($validated['amount'] * 100);

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $intent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'usd',
                'payment_method_types' => ['card'],
            ]);

            if ($intent->status === 'succeeded') {
               
                return response()->json([
                    'success' => true,
                    'message' => 'Payment confirmed successfully',
                ]);
            }

            return response()->json([
                'clientSecret' => $intent->client_secret,
            ]);

        } catch (\Exception $e) {
            Log::error('Stripe PaymentIntent Error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to create payment intent.',
            ], 500);
        }
    }
}
