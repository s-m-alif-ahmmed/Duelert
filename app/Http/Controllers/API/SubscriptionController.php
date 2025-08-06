<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Digikraaft\Paystack\Paystack;
use Digikraaft\Paystack\Plan;
use Digikraaft\PaystackSubscription\Exceptions\PaymentFailure;
use Digikraaft\PaystackSubscription\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Plan as SubsPlan;

class SubscriptionController extends Controller
{
    /**
     *
     * @throws PaymentFailure
     */
    public function handlePaystackPostCallBack()
    {


        try {
            // get transaction reference returned by Paystack
            $transactionRef = request()->input('reference');

            //verify the transaction is valid
            $transaction = Payment::hasValidTransaction($transactionRef);

            if ($transaction) {


                auth()->user()
                    ->newSubscription('default', $transaction->data->plan)
                    ->create($transaction->data->id);

                return Helper::jsonResponse(true, 'Subscription created successfully', 200);
            }

            throw PaymentFailure::incompleteTransaction($transaction);
        } catch (Exception $exception) {

            return Helper::jsonErrorResponse($exception->getMessage(), 500);
        }
    }

    /**
     * Cancel the subscription at the end of the current billing period
     */
    /*    public function cancel()
    {
        auth()->user()
            ->subscription()
            ->cancel();

        return redirect('home');
    } */

    public function cancel()
    {
        $user = auth()->user();
        $subs = $user->subscriptions;
        $subscription = $user->subscription('default');

        // dd($subs);

        if ($subs->isEmpty()) {
            return Helper::jsonErrorResponse('No subscriptions found in DB.', 404);
        }

        if ($user->subscribed('default')) {
            $user->subscription('default')->cancel();
            return Helper::jsonResponse(true, 'Subscription cancelled successfully', 200);
        }

        return Helper::jsonErrorResponse('No active subscription found.', 500);
    }


    /**
     * Restart a canceled subscription
     */
    public function restart()
    {
        auth()->user()
            ->subscription()
            ->enable();

        return redirect('home');
    }

    public function freeSubscription(Request $request)
    {

        $userid = auth()->id();

        $exists = DB::table('dk_subscriptions')->where('user_id', $userid)->first();
        //->where('type', 'free')

        if ($exists) {
            return Helper::jsonErrorResponse('You already have subscription.', 500);
        }

        $plan = SubsPlan::where('type', 'free')->first();

        $store = DB::table('dk_subscriptions')->insert([
            'user_id'           => $userid,
            'name'              => 'free',
            'type'              => 'free',
            'paystack_id'       => "free",
            'paystack_status'   => 'active',
            'paystack_plan'     => $plan->plan_code,
            'ends_at'           => $request->ends_at,
            'quantity'          => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return Helper::jsonResponse(true, 'Free subscription activated successfully.', 200);
    }
}
