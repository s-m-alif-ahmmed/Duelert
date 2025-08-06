<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class PlanController extends Controller
{
    /**
     * Display a listing of dynamic page content.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Plan::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('title', function ($data) {
                    return $data->title;
                })
                ->addColumn('type', function ($data) {
                    return $data->type;
                })
                ->addColumn('plan_code', function ($data) {
                    return $data->plan_code;
                })
                ->addColumn('currency', function ($data) {
                    return $data->currency;
                })
                ->addColumn('price', function ($data) {
                    return number_format($data->price, 2);
                })             
                ->addColumn('sms_limit', function ($data) {
                    return $data->sms_limit;
                })
                ->addColumn('customize_birth_message', function ($data) {
                    $string = strip_tags($data->customize_birth_message);
                    if (strlen($string) > 20) {
                        return substr($string, 0, 20) . '...';
                    }
                    return $string;
                })
                ->addColumn('status', function ($data) {
                    $backgroundColor  = $data->status == "active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "active" ? '26px' : '2px';
                    $sliderStyles     = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('plan.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>
                                 <a href="' . route('plan.show', ['id' => $data->id]) . '" type="button" class="btn btn-success fs-14 text-white" title="View">
                                    <i class="fe fe-eye"></i>
                                </a>
                               
                            </div>';
                })
                ->rawColumns(['title', 'type','plan_code','currency', 'price','sms_limit', 'customize_birth_message', 'status', 'action'])
                ->make();
        }
        return view('backend.layouts.plan.index');
    }

    public function edit(int $id): View
    {
        $data = Plan::find($id);
        return view('backend.layouts.plan.edit', compact('data'));
    }

    /**
     * Update the specified dynamic page content in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // dd($request->all());
        try {
            // ✅ Validation
            $validator = Validator::make($request->all(), [
                'title'                  => 'nullable|string|max:255',
                'type'                   => 'nullable|in:starter,professional,company',
                'plan_code'              => 'nullable|string',
                'currency'               => 'nullable|string',
                'price'                  => 'nullable|numeric',
                'customers_limit'        => 'nullable|integer',
                'storage_limit'          => 'nullable|integer',
                'sms_limit'              => 'nullable|integer',
                'customize_birth_message'=> 'nullable|string',
            ]);

            // dd($validator->validated());

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // ✅ Manually Fetch Plan Using ID
            $plan = Plan::findOrFail($id);

            // ✅ Update Data
            $plan->title                  = $request->title;
            $plan->type                   = $request->type;
            $plan->plan_code              = $request->plan_code;
            $plan->currency               = $request->currency;
            $plan->price                  = $request->price;
            $plan->customers_limit        = $request->customers_limit;
            $plan->storage_limit          = $request->storage_limit;
            $plan->sms_limit              = $request->sms_limit;
            $plan->customize_birth_message= $request->customize_birth_message;
            
            $plan->save();

            return redirect()->route('plan.index')->with('t-success', 'Plan updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('plan.index')->with('t-error', 'Plan update failed: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        try {
            // ✅ Fetch the Blog by ID
            $data = Plan::findOrFail($id);

            // ✅ Return the view with blog data
            return view('backend.layouts.plan.show', compact('data'));
        } catch (\Exception $e) {
            // If blog not found, redirect with error
            return redirect()->route('plan.index')->with('t-error', 'Plan not found.');
        }
    }



    /**
     * Change the status of the specified dynamic page content.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse
    {
        $data = Plan::findOrFail($id);
        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        }
    }

    /**
     * Remove the specified dynamic page content from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data = Plan::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Plan deleted successfully.',
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the Plan.',
            ]);
        }
    }
}
