<?php

namespace App\Http\Controllers\API\Plans;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function plans()
    {
        try {
            $plans = Plan::where('status', 'active')->get();

            if (!$plans) {
                return Helper::jsonErrorResponse('Plan not found!', 404);
            }

            return Helper::jsonResponse(true, 'Plans retrieved successfully!', 200, $plans);

        } catch (\Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }
}
