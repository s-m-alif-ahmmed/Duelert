<?php

namespace App\Http\Controllers\API\ourNumber;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Reminder;
use Illuminate\Http\Request;

class OurNumberController extends Controller
{
    public function index()
    {
        try {
            $reminder = Reminder::all()->count();
            $customers = Contact::all()->count();
            //unique user_id fetch count from contacts
            $companies = Contact::distinct('user_id')->count();

            return Helper::jsonResponse(true, 'Our numbers retrieved successfully', 200, [
                'reminder' => $reminder,
                'customers' => $customers,
                'companies' => $companies,
            ]);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong: ' . $e->getMessage(), 500);
        }
    }
}
