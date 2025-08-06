<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        $socialMedia = SocialMedia::all();
        return view('backend.layouts.social-media.social-media', compact('socialMedia'));
    }

    public function create()
    {
        return view('backend.layouts.social-media.create-social');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'platform'  => 'required|string|unique:social_media,platform',
            'link'      => 'required|url',
            'status'    => 'required|in:active,inactive',
        ]);

        SocialMedia::create($validatedData);

        return redirect()->route('social.media')->with('t-success', 'Social Media link created successfully');
    }
    public function update(Request $request, $id)
    {
        $socialMedia = SocialMedia::findOrFail($id);

        $validatedData = $request->validate([
            'link'      => 'required|url',
            'status'    => 'required|in:active,inactive',
        ]);

        $socialMedia->update($validatedData);

        return redirect()->route('social.media')->with('t-success', 'Social Media link updated successfully');
    }

    public function destroy($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->delete();

        return redirect()->route('social.media')->with('t-success', 'Social Media link deleted successfully');
    }
}
