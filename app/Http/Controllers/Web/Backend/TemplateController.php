<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class TemplateController extends Controller
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
            $data = Template::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('type', function ($data) {
                    return $data->type;
                })
                ->addColumn('message', function ($data) {
                    return Str::limit($data->message, 50) . (strlen($data->message) > 50 ? '...' : '');
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
                                <a href="' . route('template.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>
                                 <a href="' . route('template.show', ['id' => $data->id]) . '" type="button" class="btn btn-success fs-14 text-white" title="View">
                                    <i class="fe fe-eye"></i>
                                </a>

                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['type', 'message', 'status', 'action'])
                ->make();
        }
        return view('backend.layouts.template.index');
    }


    public function create(): View
    {
        return view('backend.layouts.template.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:birthday,anniversary,festive,thank_you,congratulations,reminders,invitations,professional,welcome',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $template = Template::create([
                'type' => $request->type,
                'message' => $request->message
            ]);
            return redirect()->route('template.index')->with('t-success', 'Template created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', 'An error occurred while creating the template')->withInput();
        }
    }


    public function edit($id): View
    {
        $data = Template::findOrFail($id);
        return view('backend.layouts.template.edit', compact('data'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:birthday,anniversary,festive,thank_you,congratulations,reminders,invitations,professional,welcome',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $template = Template::findOrFail($id);
            $template->update([
                'type' => $request->type,
                'message' => $request->message
            ]);
            return redirect()->route('template.index')->with('t-success', 'Template updated successfully');
        } catch (\Exception $e) {    
            return redirect()->back()->with('t-error', 'An error occurred while updating the template')->withInput();
        }
    }

    /**
     * Change the status of the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = Template::findOrFail($id);
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        $user = Template::findOrFail($id);
        $user->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }


    public function show($id): View
    {
        $data = Template::find($id);
        return view('backend.layouts.template.show', compact('data'));
    }
}
