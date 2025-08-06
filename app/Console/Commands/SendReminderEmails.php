<?php

namespace App\Console\Commands;

use App\Models\Reminder;
use App\Notifications\ReminderNotification;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/* class SendReminderEmails extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send reminder emails based on reminder_time';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // 24-hour format
        $now = Carbon::now(config('app.timezone'))->format('Y-m-d H:i:s');
        Log::info("Checking for reminders at: " . $now);

        $reminders = Reminder::whereRaw("DATE_FORMAT(reminder_time, '%Y-%m-%d %H:%i:%s') = ?", [$now])->get();
        Log::info("Reminders found: " . $reminders->count());

        if ($reminders->isEmpty()) {
            Log::info("No reminders found for this time.");
        } else {
            foreach ($reminders as $reminder) {
                Log::info("Sending reminder to: " . $reminder->email);

                $reminder->notify(new ReminderNotification($reminder));

                //after sent notification status will be update
                $reminder->status = 'successful';
                $reminder->save();

                Log::info("Reminder email sent to: " . $reminder->email);
            }
        }
    }
} */

class SendReminderEmails extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send reminder emails and SMS based on reminder_time';

    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        parent::__construct();
        $this->twilio = $twilio;
    }

    public function handle()
    {
        $now = Carbon::now(config('app.timezone'))->format('Y-m-d H:i:s');
        Log::info("Checking for reminders at: " . $now);

        $reminders = Reminder::whereRaw("DATE_FORMAT(reminder_time, '%Y-%m-%d %H:%i:%s') = ?", [$now])->get();
        Log::info("Reminders found: " . $reminders->count());

        if ($reminders->isEmpty()) {
            Log::info("No reminders found for this time.");
        } else {
            foreach ($reminders as $reminder) {
                // Send email
                // Log::info("Sending email reminder to: " . $reminder->email);
                $reminder->notify(new ReminderNotification($reminder));
                // Log::info("Email sent to: " . $reminder->email);

                // Send SMS via Twilio
                try {
                    // Log::info("Sending SMS to: " . $reminder->phone);
                    $this->twilio->sendSMS($reminder->phone, $reminder->message);
                    // Log::info("SMS sent to: " . $reminder->phone);
                } catch (\Exception $e) {
                    Log::error("Failed to send SMS to: " . $reminder->phone . " | Error: " . $e->getMessage());
                }

                // Update status
                $reminder->status = 'successful';
                $reminder->save();
            }
        }
    }
}
