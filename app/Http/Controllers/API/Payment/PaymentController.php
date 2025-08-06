<?php

namespace App\Http\Controllers\API\Payment;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Carbon\Carbon;
use Digikraaft\Paystack\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // Make payment (now payment created via this method for testing) 
    public function initializePayment(Request $request)
    {
        $url = "https://api.paystack.co/transaction/initialize";

        // dd($request->all());
        $userid = auth()->id();

        // $exists = DB::table('dk_subscriptions')
        //     ->where('user_id', $userid)
        //     ->where('paystack_plan', $request->plan)
        //     ->whereNotNull('ends_at')
        //     ->where('ends_at', '>=', now())
        //     ->first();


        // if ($exists != null) {
        //     return Helper::jsonErrorResponse('You already used this subscription.', 500);
        // }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET'),
            'Content-Type' => 'application/json',
        ])->post($url, [
            "email" => auth()->user()->email,
            "customer" => "CUS_xxxxxxxxxx",
            "amount" => 1000,
            "plan" => $request->plan, // Amount in kobo (Naira)
            "callback_url" => env('PAYSTACK_CALLBACK_URL'),
        ]);

        return $response->json();  // Return the response from Paystack
    }
}
