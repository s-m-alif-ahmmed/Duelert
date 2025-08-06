<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically expire subscriptions when their end date is reached';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Log::info('ExpireSubscriptions command is running...');
        // Get the current date
        $today = Carbon::today();

        // Find all subscriptions that are still active and have an end_date in the past
        $subscriptions = Subscription::where('status', 'active')
            ->whereDate('end_date', '<', $today)
            ->get();

        // Update each subscription to 'expired'
        foreach ($subscriptions as $subscription) {
            $subscription->status = 'expired';
            $subscription->save();
        }
        
        // Log::info('Expired subscriptions have been updated.');

        // Output to console
        $this->info('expired ' . $subscriptions->count() . ' subscriptions.');
    }
}