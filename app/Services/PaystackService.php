<?php
namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    private $client;
    private $baseURL = 'https://api.paystack.com';

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . config('paystack.secret_key'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function makeRequest($method, $endpoint, array $options = [])
    {
        try {
            $response = $this->client->request($method, $this->baseURL . $endpoint, $options);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            Log::error('Paystack API Error: ' . $e->getMessage());
            throw new Exception("Failed to communicate with Paystack: " . $e->getMessage());
        }
    }

    public function createPlan(array $data)
    {
        $endpoint = '/plan';
        return $this->makeRequest('POST', $endpoint, ['json' => $data]);
    }

    public function initializeTransaction(array $data)
    {
        $endpoint = '/transaction/initialize';
        return $this->makeRequest('POST', $endpoint, ['json' => $data]);
    }

    public function verifySignature($body, $signature): bool
    {
        $secret_key = config('paystack.secret_key');
        $computed_signature = hash_hmac('sha512', $body, $secret_key);
        return hash_equals($computed_signature, $signature);
    }

    /**
     * @throws Exception
     */
    public function handleSubscriptionCreate($data): void
    {
        $plan_code = $data['plan_id'];
        $customer_code = $data['customer_id'];
        $subscription_code = $data['id'];

        $plan = \App\Models\Plan::where('plan_code', $plan_code)->first();
        if (!$plan) {
            throw new Exception("Plan not found for code: $plan_code");
        }

        $customer = \App\Models\User::firstOrCreate(
            ['email' => $data['customer']['email']],
            [
                'customer_code' => $customer_code,
                'name' => $data['customer']['name'] ?? 'Unknown',
                'email' => $data['customer']['email'],
                'password' => bcrypt(\Str::random(10)),
            ]
        );

        \App\Models\Subscription::create([
            'plan_id' => $plan->id,
            'user_id' => $customer->id,
            'subscription_code' => $subscription_code,
            'status' => $data['status'],
            'start_date' => $data['period_start'],
            'end_date' => $data['period_end'],
        ]);
    }

    public function handleChargeSuccess($data)
    {
        $subscription_code = $data['subscription_id'];
        $subscription = \App\Models\Subscription::where('subscription_code', $subscription_code)->first();
        if (!$subscription) {
            throw new Exception("Subscription not found for code: $subscription_code");
        }

        $subscription->end_date = $subscription->plan->calculateNextPaymentDate($subscription->end_date);
        $subscription->save();

        \App\Models\Transaction::create([
            'subscription_id' => $subscription->id,
            'transaction_id' => $data['id'],
            'amount' => $data['amount'],
            'status' => $data['status'],
        ]);
    }
}
