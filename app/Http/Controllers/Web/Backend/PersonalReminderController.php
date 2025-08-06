<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\PersonalReminderCompanion;
use Illuminate\Http\Request;

class PersonalReminderController extends Controller
{
    public function personalreminderEdit()
    {
        $data = PersonalReminderCompanion::find(1);
        return view('backend.layouts.cms.personal-reminder', compact('data'));
    }
    
    public function personalreminderUpdate(Request $request)
    {       
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
            'description' => 'nullable|string|max:1000',
        ]);

        $data = PersonalReminderCompanion::find(1);

        if (!$data) {
            return redirect()->back()->with('t-error', 'Data not found');
        }

        // Update the data
        $updated = $data->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            // delete old image
            if (file_exists($data->image)) {
                Helper::fileDelete($data->image);
            }
            // new image upload
            $imagePath = Helper::fileUpload($request->file('image'), 'PersonalReminder', time() . '_' . $request->file('image')->getClientOriginalName());
            $data->image = $imagePath;
        }

        $data->save();

        return redirect()->route('personal.reminder.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
}
