<?php

namespace App\Http\Controllers\API\Logo;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    public function logo()
    {
        try {
            $systemSetting = SystemSetting::first();
            
            if ($systemSetting && $systemSetting->logo) {
                return Helper::jsonResponse(true, 'Logo Retrieved Successfully', 200, ['logo' => $systemSetting->logo,'white_logo' => url($systemSetting->white_logo)]);
            }
            
            return Helper::jsonResponse(true, 'Logo not found', 200);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('An error occurred while retrieving the logo', 500);
        }
    }
    public function coppyrightText(){
        try {
            $systemSetting = SystemSetting::first();
            
            if ($systemSetting && $systemSetting->copyright_text) {
                return Helper::jsonResponse(true, 'Copyright Text Retrieved Successfully', 200, ['copyright_text' => $systemSetting->copyright_text]);
            }
            
            return Helper::jsonResponse(true, 'Copyright text not found', 200);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('An error occurred while retrieving Copyright Text', 500);
        }

    }
    public function abouteSystem(){
        try {
            $systemSetting = SystemSetting::first();
            
            if ($systemSetting && $systemSetting->description) {
                return Helper::jsonResponse(true, 'Aboute System Text Retrieved Successfully', 200, ['abouteSystem' => $systemSetting->description]);
            }
            
            return Helper::jsonResponse(true, 'About system not found', 200);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('An error occurred while retrieving the logo', 500, [], $e->getMessage());
        }

    }



}
