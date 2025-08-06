<?php

namespace App\Http\Controllers\API\Templates;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function templateList()
    {
        try {
            $templates = Template::where('status', 'active')->orderBy('id', 'desc')->get();
            return Helper::jsonResponse(true, 'Templates Retrieved Successfully', 200, $templates);
        } catch (\Exception $e) {
            return Helper::jsonErrorResponse($e->getMessage(), 500);
        }
    }
}
