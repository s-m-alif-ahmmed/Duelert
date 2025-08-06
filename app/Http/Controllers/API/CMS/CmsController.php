<?php

namespace App\Http\Controllers\API\CMS;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CMS;
use App\Models\ContactInfo;
use App\Models\DynamicPage;
use App\Models\Faq;
use App\Models\FeelTopOnTheWorld;
use App\Models\OurKeyHighlight;
use App\Models\OurMission;
use App\Models\PersonalReminderCompanion;
use App\Models\SocialMedia;
use App\Models\ValueWeOffer;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;

class CmsController extends Controller
{

    //Banner retrieve
    public function index()
    {
        try {
            $cms = CMS::all();
            return Helper::jsonResponse(true, 'Banners Retrived Successfully', 200, $cms);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    //Dynamic page retrieve

    public function dynamicPage(Request $request)
    {
        try {
            $dynamicPage = DynamicPage::query()
                ->select(['page_title', 'page_content'])
                ->where('status', 'active')
                ->get();

            return Helper::jsonResponse(true, 'Dynamic pages retrieved successfully', 200, $dynamicPage);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    //Faq retrieve
    public function faq()
    {
        try {
            $faq = Faq::where('status', 'active')->latest()->get();
            return Helper::jsonResponse(true, 'Faq Retrived Successfully', 200, $faq);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    //    Why Choose Us
    public function whyChooseUs()
    {
        try {
            $whyChooseUs = WhyChooseUs::where('status', 'active')->latest()->get();
            return Helper::jsonResponse(true, 'Why Choose Us Retrived Successfully', 200, $whyChooseUs);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }
    //    Our Key Highlight
    public function ourKeyHighlight()
    {
        try {
            $ourKeyHighlight = OurKeyHighlight::where('status', 'active')->latest()->get();
            return Helper::jsonResponse(true, 'Our Key Highlight Retrived Successfully', 200, $ourKeyHighlight);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }
    //    Personal Reminder Companion
    public function personalReminder()
    {
        try {
            $personalReminders = PersonalReminderCompanion::where('status', 'active')->latest()->get();
            return Helper::jsonResponse(true, 'Personal Reminder Retrieved Successfully', 200, $personalReminders);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }


    //    Feel Top On The World
    public function FeelTopOnTheWorld()
    {
        try {
            $data = FeelTopOnTheWorld::where('status', 'active')->latest()->get();
            return Helper::jsonResponse(true, 'Feel Top On The World Retrived Successfully', 200, $data);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    //    Value We Offer
    public function ValueWeOffer()
    {
        try {
            $data = ValueWeOffer::findorfail(1);
            return Helper::jsonResponse(true, 'Value We Offer Retrived Successfully', 200, $data);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    //    Our Mission
    public function ourMission()
    {
        try {
            $data = OurMission::findorfail(1);
            return Helper::jsonResponse(true, 'Our Mission Retrived Successfully', 200, $data);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    //    Contact Info
    public function contactInfo()
    {
        try {
            $data = ContactInfo::findorfail(1);
            return Helper::jsonResponse(true, 'Contact Info Retrived Successfully', 200, $data);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    //    Social Media
    public function socialMedia()
    {
        try {
            $data = SocialMedia::where('status', 'active')->get();
            return Helper::jsonResponse(true, 'Social Media Retrived Successfully', 200, $data);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    //    Blog
    public function blog()
    {
        try {
            $data = Blog::where('status', 'active')->get();
            return Helper::jsonResponse(true, 'Blogs Retrived Successfully', 200, $data);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('Something went wrong', 500);
        }
    }

    //Blog Details
    public function blogDetails($id)
    {
        $blog = Blog::with('user')->where('status', 'active')->find($id);

        if (!$blog) {
            return Helper::jsonErrorResponse('Blog not found!', 404);
        }

        $time = $blog->created_at->format('h:i A');
        $date = $blog->created_at->format('d/m/Y');

        $ago = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->created_at)->diffForHumans(now());

        return Helper::jsonResponse(true, 'Blog details fetched successfully!', 200, [
            'blog' => $blog,
            'time' => $time,
            'date' => $date,
            'Time ago' => $ago
        ]);
    }
}
