<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\FeelTopOnTheWorld;
use Illuminate\Http\Request;

class FeelTopOnTheWorldController extends Controller
{
    public function feelEdit()
    {
        $data = FeelTopOnTheWorld::find(1);
        return view('backend.layouts.cms.feel-top', compact('data'));
    }
    
    public function feelUpdate(Request $request)
    {       
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'button_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
        ]);

        $data = FeelTopOnTheWorld::find(1);

        if (!$data) {
            return redirect()->back()->with('t-error', 'Data not found');
        }

        // Update the data
        $updated = $data->update([
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text
        ]);

        if ($request->hasFile('image')) {
            // delete old image
            if (file_exists($data->image)) {
                Helper::fileDelete($data->image);
            }
            // new image upload
            $imagePath = Helper::fileUpload($request->file('image'), 'FeelTopOnTheWorld', time() . '_' . $request->file('image')->getClientOriginalName());
            $data->image = $imagePath;
        }

        $data->save();

        return redirect()->route('feel.top.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
}
