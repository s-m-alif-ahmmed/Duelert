<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Models\CMS;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use PHPUnit\TextUI\Help;
use Yajra\DataTables\DataTables;

class CmsController
{
    public function HomeBannerEdit()
    {
        $data = CMS::find(1);
        return view('backend.layouts.cms.home-banner', compact('data'));
    }
    
    public function updateHomeBanner(Request $request)
    {
        
        // Validate the request
        $request->validate([
            'home_banner_title' => 'nullable|string',
            'home_banner_subtitle' => 'nullable|string',
            'button_text' => 'nullable|string',
            'home_banner' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
            'home_banner_two' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
            'home_banner_three' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
            'home_banner_four' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
            'home_banner_five' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
        ]);
        
        $data = CMS::find(1);
        
        if (!$data) {
            return redirect()->back()->with('t-error', 'Home Banner not found');
        }
        
        // Update the data
        $updated = $data->update([
            'home_banner_title' => $request->home_banner_title,
            'home_banner_subtitle' => $request->home_banner_subtitle,
            'button_text' => $request->button_text
        ]);
        
        $bannerFields = [
            'home_banner',
            'home_banner_two',
            'home_banner_three',
            'home_banner_four',
            'home_banner_five',
        ];
        
        foreach ($bannerFields as $field) {
            if ($request->hasFile($field)) {
                // delete old image
                if (file_exists($data->{$field})) {
                    Helper::fileDelete($data->{$field});
                }
                // new image upload
                $imagePath = Helper::fileUpload($request->file($field), 'Banner', time() . '_' . $request->file($field)->getClientOriginalName());
                $data->{$field} = $imagePath;
            }
        }
        
        $data->save();
        
        return redirect()->route('home.banner.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
    
    public function aboutBannerEdit()
    {
        $data = CMS::find(2);
        return view('backend.layouts.cms.about-banner', compact('data'));
    }

    public function aboutBannerUpdate(Request $request)
    {
        
        // Validate the request
        $request->validate([
            'about_page_title' => 'nullable|string|max:255',           
            'about_page_banner' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',           
        ]);
        
        $data = CMS::find(2);
        
        if (!$data) {
            return redirect()->back()->with('t-error', 'Banner not found');
        }
        
        // Update the data
        $updated = $data->update([
            'about_page_title' => $request->about_page_title
        ]);
        
        if ($request->hasFile('about_page_banner')) {
            // delete old image
            if (file_exists($data->about_page_banner)) {
                Helper::fileDelete($data->about_page_banner);
            }
            // new image upload
            $imagePath = Helper::fileUpload($request->file('about_page_banner'), 'Banner', time() . '_' . $request->file('about_page_banner')->getClientOriginalName());
            $data->about_page_banner = $imagePath;
        }
        
        $data->save();
        
        return redirect()->route('about.banner.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
    public function blogBannerEdit()
    {
        $data = CMS::find(3);
        return view('backend.layouts.cms.blog-banner', compact('data'));
    }

    public function blogBannerUpdate(Request $request)
    {
        
        // Validate the request
        $request->validate([
            'blog_page_title' => 'nullable|string|max:255',           
            'blog_page_banner' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',           
        ]);
        
        $data = CMS::find(3);
        
        if (!$data) {
            return redirect()->back()->with('t-error', 'Banner not found');
        }
        
        // Update the data
        $updated = $data->update([
            'blog_page_title' => $request->blog_page_title
        ]);
        
        if ($request->hasFile('blog_page_banner')) {
            // delete old image
            if (file_exists($data->blog_page_banner)) {
                Helper::fileDelete($data->blog_page_banner);
            }
            // new image upload
            $imagePath = Helper::fileUpload($request->file('blog_page_banner'), 'Banner', time() . '_' . $request->file('blog_page_banner')->getClientOriginalName());
            $data->blog_page_banner = $imagePath;
        }
        
        $data->save();
        
        return redirect()->route('blog.banner.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
    public function blogDetailsBannerEdit()
    {
        $data = CMS::find(4);
        return view('backend.layouts.cms.blog-details-banner', compact('data'));
    }

    public function blogDetailsBannerUpdate(Request $request)
    {
        
        // Validate the request
        $request->validate([
            'blog_details_title' => 'nullable|string|max:255',           
            'blog_details_banner' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',           
        ]);
        
        $data = CMS::find(4);
        
        if (!$data) {
            return redirect()->back()->with('t-error', 'Banner not found');
        }
        
        // Update the data
        $updated = $data->update([
            'blog_details_title' => $request->blog_details_title
        ]);
        
        if ($request->hasFile('blog_details_banner')) {
            // delete old image
            if (file_exists($data->blog_details_banner)) {
                Helper::fileDelete($data->blog_details_banner);
            }
            // new image upload
            $imagePath = Helper::fileUpload($request->file('blog_details_banner'), 'Banner', time() . '_' . $request->file('blog_details_banner')->getClientOriginalName());
            $data->blog_details_banner = $imagePath;
        }
        
        $data->save();
        
        return redirect()->route('blog.details.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
    public function contactBannerEdit()
    {
        $data = CMS::find(5);
        return view('backend.layouts.cms.contact-banner', compact('data'));
    }

    public function contactBannerUpdate(Request $request)
    {
        
        // Validate the request
        $request->validate([
            'contact_page_title' => 'nullable|string|max:255',           
            'contact_page_banner' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',           
        ]);
        
        $data = CMS::find(5);
        
        if (!$data) {
            return redirect()->back()->with('t-error', 'Banner not found');
        }
        
        // Update the data
        $updated = $data->update([
            'contact_page_title' => $request->contact_page_title
        ]);
        
        if ($request->hasFile('contact_page_banner')) {
            // delete old image
            if (file_exists($data->contact_page_banner)) {
                Helper::fileDelete($data->contact_page_banner);
            }
            // new image upload
            $imagePath = Helper::fileUpload($request->file('contact_page_banner'), 'Banner', time() . '_' . $request->file('contact_page_banner')->getClientOriginalName());
            $data->contact_page_banner = $imagePath;
        }
        
        $data->save();
        
        return redirect()->route('contact.banner.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
    public function loginBannerEdit()
    {
        $data = CMS::find(6);
        return view('backend.layouts.cms.login-banner', compact('data'));
    }

    public function loginBannerUpdate(Request $request)
    {
        
        // Validate the request
        $request->validate([        
            'login_banner' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',           
        ]);
        
        $data = CMS::find(6);
        
        if (!$data) {
            return redirect()->back()->with('t-error', 'Banner not found');
        }
        
        // Update the data
        $updated = $data->update([            
        ]);
        
        if ($request->hasFile('login_banner')) {
            // delete old image
            if (file_exists($data->login_banner)) {
                Helper::fileDelete($data->login_banner);
            }
            // new image upload
            $imagePath = Helper::fileUpload($request->file('login_banner'), 'Banner/login', time() . '_' . $request->file('login_banner')->getClientOriginalName());
            $data->login_banner = $imagePath;
        }
        
        $data->save();
        
        return redirect()->route('login.banner.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }
    public function signupBannerEdit()
    {
        $data = CMS::find(7);
        return view('backend.layouts.cms.signup-banner', compact('data'));
    }

    public function signupBannerUpdate(Request $request)
    {
        
        // Validate the request
        $request->validate([        
            'signup_banner' => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',           
        ]);
        
        $data = CMS::find(7);
        
        if (!$data) {
            return redirect()->back()->with('t-error', 'Banner not found');
        }
        
        // Update the data
        $updated = $data->update([
           
        ]);
        
        if ($request->hasFile('signup_banner')) {
            // delete old image
            if (file_exists($data->signup_banner)) {
                Helper::fileDelete($data->signup_banner);
            }
            // new image upload
            $imagePath = Helper::fileUpload($request->file('signup_banner'), 'Banner/signup', time() . '_' . $request->file('signup_banner')->getClientOriginalName());
            $data->signup_banner = $imagePath;
        }
        
        $data->save();
        
        return redirect()->route('signup.banner.edit')->with(
            $updated ? 't-success' : 't-error',
            $updated ? 'Data Updated Successfully' : 'Data update failed!'
        );
    }

}
