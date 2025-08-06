<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class PackageInfoController extends Controller
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
            $data = DB::table('dk_subscriptions')
                ->where('paystack_status', 'active')
                ->latest()
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                    $user = DB::table('users')->where('id', $data->user_id)->first();
                    return $user ? $user->name : 'N/A';
                })
                ->addColumn('paystack_plan', function ($data) {
                    $plan = DB::table('plans')->where('plan_code', $data->paystack_plan)->first();
                    return $plan->type;
                })
                ->addColumn('price', function ($data) {
                    $plan = DB::table('plans')->where('plan_code', $data->paystack_plan)->first();
                    return $plan->price;
                })
                ->addColumn('paystack_status', function ($data) {
                    return $data->paystack_status;
                })
                ->addColumn('ends_at', function ($data) {
                    return $data->ends_at;
                })                

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">                               
                                </a>
                                 <a href="' . route('package.show', ['id' => $data->id]) . '" type="button" class="btn btn-success fs-14 text-white" title="View">
                                    <i class="fe fe-eye"></i>
                                </a>
                               
                            </div>';
                })
                ->rawColumns(['name', 'paystack_plan','price', 'paystack_status', 'ends_at','action'])
                ->make();
        }
        return view('backend.layouts.subscription.index');
    }


    /**
     * Change the status of the specified dynamic page content.
     *
     * @param int $id
     * @return JsonResponse
     */
   /*  public function status(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:active,expired,pending',
        ]);

        $data = Subscription::findOrFail($id);
        $data->status = $request->status;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'data'    => $data,
        ]);
    } */



    public function show($id)
    {
        $data = DB::table('dk_subscriptions')->where('id', $id)->first();
        return view('backend.layouts.subscription.show', compact('data'));
    }
}
