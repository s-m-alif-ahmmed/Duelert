<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ValueWeOffer;
use Illuminate\Http\Request;

class ValueWeOfferController extends Controller
{
    public function valueEdit()
    {
        $data = ValueWeOffer::find(1);
        return view('backend.layouts.cms.value-we-offer', compact('data'));
    }
    
    public function valueUpdate(Request $request)
    {       
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_one' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
            'image_two' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
        ]);

        $data = ValueWeOffer::find(1);

        if (!$data) {
            return redirect()->back()->with('t-error', 'Data not found');
        }

        $updated = $data->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image_one')) {
            if (file_exists($data->image_one)) {
                Helper::fileDelete($data->image_one);
            }
            $imagePath = Helper::fileUpload($request->file('image_one'), 'valueWeOffer/image_one', time() . '_' . $request->file('image_one')->getClientOriginalName());
            $data->image_one = $imagePath;
        }
        if ($request->hasFile('image_two')) {
            if (file_exists($data->image_two)) {
                Helper::fileDelete($data->image_two);
            }
            $imagePath = Helper::fileUpload($request->file('image_two'), 'valueWeOffer/image_two', time() . '_' . $request->file('image_two')->getClientOriginalName());
            $data->image_two = $imagePath;
        }

        $data->save();

        return redirect()->route('value.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
}
