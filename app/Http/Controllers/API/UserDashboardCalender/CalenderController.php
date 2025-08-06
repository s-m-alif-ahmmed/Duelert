<?php

namespace App\Http\Controllers\API\UserDashboardCalender;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CalenderController extends Controller
{
    public function addEvent(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'event_date' => 'required|date',
                'event_message' => 'required|string',
            ]);

            if ($validator->fails()) {
                return Helper::jsonErrorResponse($validator->errors()->first(), 422);
            }

            $user = auth()->user();

            $calendar = new \App\Models\Calendar();
            $calendar->user_id = $user->id;
            $calendar->event_date = $request->input('event_date');
            $calendar->event_message = $request->input('event_message');
            $calendar->save();

            return Helper::jsonResponse(true, 'Event added successfully', 200, $calendar);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }


    public function getEvents(Request $request)
    {
        try {
            $user = auth()->user();

            $events = Calendar::with('user:id,name,avatar,email')
                ->where('user_id', $user->id)
                ->get();

            return Helper::jsonResponse(true, 'Events fetched successfully', 200, $events);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }
}
