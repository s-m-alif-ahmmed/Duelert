<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function contactEdit()
    {
        $data = ContactInfo::find(1);
        return view('backend.layouts.cms.contact-info', compact('data'));
    }
    
    public function contactUpdate(Request $request)
    {       
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|string|email',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
        ]);

        $data = ContactInfo::find(1);

        if (!$data) {
            return redirect()->back()->with('t-error', 'Data not found');
        }

        // Update the data
        $updated = $data->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        if ($request->hasFile('image')) {
            // delete old image
            if (file_exists($data->image)) {
                Helper::fileDelete($data->image);
            }
            // new image upload
            $imagePath = Helper::fileUpload($request->file('image'), 'ContactInfo', time() . '_' . $request->file('image')->getClientOriginalName());
            $data->image = $imagePath;
        }

        $data->save();

        return redirect()->route('contact.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
}
