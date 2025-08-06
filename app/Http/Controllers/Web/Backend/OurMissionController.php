<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\OurMission;
use Illuminate\Http\Request;

class OurMissionController extends Controller
{
    public function missionEdit()
    {
        $data = OurMission::find(1);
        return view('backend.layouts.cms.our-mission', compact('data'));
    }
    
    public function missionUpdate(Request $request)
    {       
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
        ]);

        $data = OurMission::find(1);

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
            $imagePath = Helper::fileUpload($request->file('image'), 'OurMission', time() . '_' . $request->file('image')->getClientOriginalName());
            $data->image = $imagePath;
        }

        $data->save();

        return redirect()->route('mission.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
}
