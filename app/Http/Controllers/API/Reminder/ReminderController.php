<?php

namespace App\Http\Controllers\API\Reminder;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReminderController extends Controller
{

    // Get all pending reminders
    public function index()
    {
        try {
            $data = Reminder::where('status', 'pending')->latest()->get();
            return Helper::jsonResponse(true, 'Reminders Retrived Successfully', 200, $data);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    // Get all Success reminders
    public function successReminderList()
    {
        try {
            $data = Reminder::where('status', 'successful')->latest()->get();
            return Helper::jsonResponse(true, 'Reminders Retrived Successfully', 200, $data);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    /**
     * Send a reminder to a contact
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    /*  public function createReminder(Request $request)
{
    $validatedData = $request->validate([
        'contact_id' => 'required|array',
        'contact_id.*' => 'exists:contacts,id',
        'message' => 'nullable|string', // Optional: If you want custom message also.
        'template_id' => 'nullable|exists:templates,id', // Template ID Validation
        'reminder_time' => 'nullable|date|after:now',
    ]);

    $user = auth()->user();

    try {
        // Check if the user has sufficient message_limit to send reminders
        $messageLimit = $user->message_limit;

        // If the user has no message_limit, return error
        if ($messageLimit <= 0) {
            return Helper::jsonErrorResponse('Insufficient message limit.', 400);
        }

        // Check if template exists and get the message
        $templateMessage = null;
        if ($request->template_id) {
            $template = Template::find($request->template_id);
            if ($template) {
                $templateMessage = $template->message;
            }
        }

        // Use the provided message or template message
        $finalMessage = $templateMessage ?: $request->message;

        if ($request->reminder_time) {
            try {
                // Convert AM/PM format to 24-hour format using Carbon
                $reminderTime = Carbon::createFromFormat('Y-m-d h:i:s A', $request->reminder_time)->toDateTimeString();
            } catch (\Exception $e) {
                return Helper::jsonErrorResponse("Invalid reminder time format.", 400);
            }
        } else {
            // If reminder_time is not provided, use current time
            $reminderTime = null;
        }

        $remindersCreated = 0; // Track the number of reminders created
        foreach ($request->contact_id as $contactId) {
            // Check if the authenticated user has the contact
            $contact = $user->contacts()->where('id', $contactId)->first();

            if (!$contact) {
                return Helper::jsonErrorResponse("Contact not found for this user.", 404);
            }

            // Create reminder with proper reminder_time
            $reminder =  Reminder::create([
                'user_id' => $user->id,
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'date_of_birth' => $contact->date_of_birth,
                'message' => $finalMessage,
                'reminder_time' => $reminderTime,  // This will either be the provided time or null
            ]);

            $remindersCreated++;

            // Decrease message_limit for each reminder created
            $user->decrement('message_limit', 1); // Decrease by 1 for each reminder

            // Store reminder details in the array
            $reminderDetails[] = [
                'contact_id' => $contact->id,
                'contact_name' => $contact->name,
                'message' => $finalMessage,
                'reminder_time' => $reminderTime,
                'reminder_created_at' => $reminder->created_at,
            ];
        }

        // Check if the reminders were created successfully and message limit was decreased
        if ($remindersCreated > 0) {
           return Helper::jsonResponse(true, 'Reminders Create successfully.', 201, [
            'reminder_details' => $reminderDetails, 
            'user_message_limit' => $user->message_limit,
        ]);
        } else {
            return Helper::jsonErrorResponse('No reminders were created.', 400);
        }
    } catch (\Exception $e) {
        return Helper::jsonErrorResponse($e->getMessage(), 500);
    }
} */

    public function createReminder(Request $request)
    {
        $validatedData = $request->validate([
            'contact_id' => 'required|array',
            'contact_id.*' => 'exists:contacts,id',
            'message' => 'nullable|string',
            'template_id' => 'nullable|exists:templates,id',
            'reminder_time' => 'nullable|date|after:now',
        ]);

        $user = auth()->user();



        try {
            // Get user's latest subscription
            $subscription = DB::table('dk_subscriptions')
                ->where('user_id', $user->id)
                ->whereIn('paystack_status', ['active', 'attention', 'non-renewing'])
                ->latest()
                ->first();

            // dd($subscription->paystack_plan);

            if (!$subscription) {
                return Helper::jsonErrorResponse('No subscription found for this user.', 404);
            }

            // Get the plan and sms_limit
            $plan = DB::table('plans')
                ->where('plan_code', $subscription->paystack_plan)
                ->latest('id')
                ->first();

            // dd($plan);

            if (!$plan) {
                return Helper::jsonErrorResponse('Plan not found.', 404);
            }

            // Count sent reminders
            $totalSentMessages = DB::table('reminders')
                ->where('user_id', $user->id)
                ->count();

            // Calculate remaining message limit
            $remainingLimit = $plan->sms_limit - $totalSentMessages;

            if ($remainingLimit <= 0) {
                return Helper::jsonErrorResponse('You have reached your message limit.', 400);
            }

            // Get template message if selected
            $templateMessage = null;
            if ($request->template_id) {
                $template = Template::find($request->template_id);
                if ($template) {
                    $templateMessage = $template->message;
                }
            }


            if ($plan->type == "free") {

                $finalMessage = $templateMessage;
            } else {

                $finalMessage = $request->message ?: $templateMessage;
            }

            // dd($finalMessage);


            // Format reminder time if provided
            if ($request->reminder_time) {
                try {
                    $reminderTime = Carbon::createFromFormat('Y-m-d h:i:s A', $request->reminder_time)->toDateTimeString();
                } catch (\Exception $e) {
                    return Helper::jsonErrorResponse("Invalid reminder time format.", 400);
                }
            } else {
                $reminderTime = null;
            }

            $remindersCreated = 0;
            $reminderDetails = [];

            foreach ($request->contact_id as $contactId) {
                if ($remindersCreated >= $remainingLimit) {
                    break;
                }

                $contact = $user->contacts()->where('id', $contactId)->first();

                if (!$contact) {
                    return Helper::jsonErrorResponse("Contact not found for this user.", 404);
                }

                $reminder = Reminder::create([
                    'user_id' => $user->id,
                    'contact_id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'date_of_birth' => $contact->date_of_birth,
                    'message' => $finalMessage,
                    'reminder_time' => $reminderTime,
                ]);

                $remindersCreated++;

                $reminderDetails[] = [
                    'contact_id' => $contact->id,
                    'contact_name' => $contact->name,
                    'message' => $finalMessage,
                    'reminder_time' => $reminderTime,
                    'reminder_created_at' => $reminder->created_at,
                ];
            }

            if ($remindersCreated > 0) {
                return Helper::jsonResponse(true, 'Reminders created successfully.', 201, [
                    'reminder_details' => $reminderDetails,
                    'remaining_sms_limit' => $remainingLimit - $remindersCreated,
                ]);
            } else {
                return Helper::jsonErrorResponse('You have reached your message limit.', 400);
            }
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }


    //Reminder Update
    public function updateReminder(Request $request, $id)
    {
        $reminder = Reminder::find($id);
        if (!$reminder) {
            return Helper::jsonErrorResponse('Reminder not found', 404);
        }

        $validatedData = $request->validate([
            'contact_id' => 'nullable|exists:contacts,id',
            'message' => 'nullable|string',
            'template_id' => 'nullable|exists:templates,id',
            'reminder_time' => 'nullable|date|after:now',
        ]);

        $user = auth()->user();

        try {
            // Check if template exists and get the message
            $templateMessage = null;
            if ($request->template_id) {
                $template = Template::find($request->template_id);
                if ($template) {
                    $templateMessage = $template->message;
                }
            }

            // Use the provided message or template message
            $finalMessage = $templateMessage ?: $request->message;

            // Handle reminder_time conversion
            if ($request->reminder_time) {
                try {
                    $reminderTime = Carbon::createFromFormat('Y-m-d h:i:s A', $request->reminder_time)->toDateTimeString();
                } catch (\Exception $e) {
                    return Helper::jsonErrorResponse("Invalid reminder time format.", 400);
                }
            } else {
                $reminderTime = $reminder->reminder_time;
            }

            // Update Reminder
            $reminder->message = $finalMessage;
            $reminder->reminder_time = $reminderTime;

            // If a new contact_id is provided, update it
            if ($request->contact_id) {
                $contact = $user->contacts()->where('id', $request->contact_id)->first();
                if (!$contact) {
                    return Helper::jsonErrorResponse("Contact not found for this user.", 404);
                }
                $reminder->contact_id = $contact->id;
                $reminder->name = $contact->name;
                $reminder->email = $contact->email;
                $reminder->phone = $contact->phone;
                $reminder->date_of_birth = $contact->date_of_birth;
            }

            $reminder->save();

            return Helper::jsonResponse(true, 'Reminder updated successfully.', 200, [
                'reminder' => $reminder
            ]);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }




    // Delete reminder
    public function destroy($id)
    {
        $reminder = Reminder::find($id);
        if (!$reminder) {
            return Helper::jsonErrorResponse('Reminder not found', 404);
        }

        $reminder->delete();
        return Helper::jsonResponse(true, 'Reminder deleted successfully!', 200);
    }
}
