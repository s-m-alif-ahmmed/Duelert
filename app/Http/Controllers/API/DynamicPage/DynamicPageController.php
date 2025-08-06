<?php

namespace App\Http\Controllers\API\DynamicPage;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use Illuminate\Http\Request;

class DynamicPageController extends Controller
{
    public function dynamicPage(){
        try {
            $dynamicPage = DynamicPage::latest()->get();
            
            return Helper::jsonResponse(true, 'Dynamic Page Retrieved Successfully', 200, ['dynamicPage' => $dynamicPage ?? null]);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse('An error occurred while retrieving the Dynamic Page. Error: '.$e->getMessage(), 500);
        }

    }
}
