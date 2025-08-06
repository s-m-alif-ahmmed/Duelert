<?php

namespace App\Http\Controllers\API\Contacts;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Plan;
use Digikraaft\Paystack\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    // Store Contact
    public function store(Request $request)
    {
        $userId = Auth::id();

        // Check if the user has an active subscription
        $subscription = DB::table('dk_subscriptions')
            ->where('user_id', $userId)
            ->whereIn('paystack_status', ['active', 'attention', 'non-renewing'])
            ->whereRaw('ends_at > NOW()')
            ->first();


        if (!$subscription) {
            return Helper::jsonErrorResponse('You do not have an active subscription.', 403);
        }

        // Get the plan details
        $plan = Plan::where('plan_code', $subscription->paystack_plan)->first();
        if (!$plan) {
            return Helper::jsonErrorResponse('Invalid subscription plan.', 403);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
        ]);

        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Validation error', 422, $validator->messages()->toArray());
        }

        // Create Contact
        $contact = new Contact();
        $contact->user_id = $userId;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->date_of_birth = $request->date_of_birth;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $imagePath = Helper::fileUpload($request->file('image'), 'UserContacts', time() . '_' . $request->file('image')->getClientOriginalName());
            if ($imagePath !== null) {
                $contact->image = $imagePath;
            }
        }

        $contact->save();

        return Helper::jsonResponse(true, 'Contact added successfully!', 201, $contact);
    }


    // Update Contact
    public function update(Request $request, $id)
    {
        $userId = Auth::id();

        // Get the contact
        $contact = Contact::where('user_id', $userId)
            ->where('id', $id)
            ->first();

        if (!$contact) {
            return Helper::jsonErrorResponse('Contact not found.', 404);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:contacts,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return Helper::jsonErrorResponse('Validation error', 422, $validator->messages()->toArray());
        }

        // Update Contact (only update fields that are sent)
        $contact->name = $request->name ?? $contact->name;
        $contact->email = $request->email ?? $contact->email;
        $contact->phone = $request->phone ?? $contact->phone;
        $contact->date_of_birth = $request->date_of_birth ?? $contact->date_of_birth;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            if ($contact->image) {
                Helper::fileDelete($contact->image); // old image delete
            }
            $contact->image = Helper::fileUpload(
                $request->file('image'),
                'UserContacts',
                time() . '_' . $request->file('image')->getClientOriginalName()
            );
        }

        $contact->save();

        return Helper::jsonResponse(true, 'Contact updated successfully!', 200, $contact);
    }


    // Get Contacts
    public function getContacts(Request $request)
    {
        try {
            $userId = Auth::id();
            $contacts = Contact::where('user_id', $userId)
                ->select(['id', 'name', 'email', 'phone', 'date_of_birth', 'image'])
                ->get();
            return Helper::jsonResponse(true, 'Contacts retrieved successfully!', 200, $contacts);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }
    //Delete Contact
    public function destroy(Request $request)
    {
        $userId = Auth::id();
        $contact = Contact::where('user_id', $userId)->where('id', $request->id)->first();
        if (!$contact) {
            return Helper::jsonErrorResponse('Contact not found.', 404);
        }
        $contact->delete();
        return Helper::jsonResponse(true, 'Contact deleted successfully!', 200);
    }
}
