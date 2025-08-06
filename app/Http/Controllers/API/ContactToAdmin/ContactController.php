<?php

namespace App\Http\Controllers\API\ContactToAdmin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ContactFormNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function submitContactForm(Request $request)
    {
        try {
            // Validate form data
            $validator = Validator::make($request->all(), [
                'name'        => 'required|string|max:255',
                'looking_for' => 'required|string',
                'message'     => 'required|string',
            ]);

            if ($validator->fails()) {
                return Helper::jsonResponse(false, 'Validation errors', 422, $validator->errors());
            }

            $validatedData = $validator->validated();

            // Find all admin users
            $admins = User::where('role', 'admin')->get();

            // Send notification to each admin (queued)
            foreach ($admins as $admin) {
                $admin->notify(new ContactFormNotification($validatedData));
            }

            // Return success response
            return Helper::jsonResponse(true, 'Your message has been sent to the admin', 200);
        } catch (\Exception $e) {
            Log::error('Notification Error: ' . $e->getMessage());
            return Helper::jsonErrorResponse('An error occurred while sending your message.', 500);
        }
    }
}
