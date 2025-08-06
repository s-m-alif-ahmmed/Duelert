<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\OurKeyHighlight;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class OurKeyHighlightController extends Controller
{
    /**
     * Display a listing of city content.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = OurKeyHighlight::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('title', function ($data) {
                    $title = Str::limit($data->title, 30);
                    return strlen($data->title) > 30 ? $title . '...' : $title;
                })
                ->addColumn('subtitle', function ($data) {
                    $subtitle = Str::limit($data->subtitle, 30);
                    return strlen($data->subtitle) > 30 ? $subtitle . '...' : $subtitle;
                })
                ->addColumn('image', function ($data) {
                    $defaultImage = asset('frontend/no-image.jpg');
                    if ($data->image) {
                        $url = asset($data->image);
                    } else {
                        $url = $defaultImage;
                    }
                    return '<img src="' . $url . '" alt="Image" width="50px" height="50px">';
                })
                ->addColumn('body_title', function ($data) {
                    $body_title = Str::limit($data->body_title, 30);
                    return strlen($data->body_title) > 30 ? $body_title . '...' : $body_title;
                })
                ->addColumn('icon', function ($data) {
                    $defaultIcon = asset('frontend/no-image.jpg');
                    if ($data->icon) {
                        $url = asset($data->icon);
                    } else {
                        $url = $defaultIcon;
                    }
                    return '<img src="' . $url . '" alt="icon" width="50px" height="50px">';
                })
                ->addColumn('description', function ($data) {
                    $description = Str::limit($data->description, 30);
                    return strlen($data->description) > 30 ? $description . '...' : $description;
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
                                <a href="' . route('key-highlight.edit', $data->id) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>

                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['title', 'subtitle', 'image','body_title', 'icon','description', 'status', 'action'])
                ->make();
        }
        return view('backend.layouts.our-key-highlight.index');
    }

    //create
    public function create()
    {
        return view('backend.layouts.our-key-highlight.create');
    }

    //store
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title'         => 'required|string|max:255',
            'subtitle'      => 'required|string|max:500',
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'body_title'    => 'required|string|max:255',
            'icon'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'description'   => 'required|string|max:500'
        ]);

        try {
            $data                   = new OurKeyHighlight();
            $data->title            = $request->title;
            $data->subtitle         = $request->subtitle;
            $data->body_title       = $request->body_title;
            $data->description      = $request->description;

            if ($request->hasFile('image')) {
                $imagePath = Helper::fileUpload($request->file('image'), 'OurKeyHighlight', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $data->image = $imagePath;
                }
            }
            if ($request->hasFile('icon')) {
                $imagePath = Helper::fileUpload($request->file('icon'), 'OurKeyHighlight/icon', time() . '_' . $request->file('icon')->getClientOriginalName());
                if ($imagePath !== null) {
                    $data->icon = $imagePath;
                }
            }

            $data->save();

            // Redirect or return a response
            return redirect()->route('key-highlight.index')->with('t-success', 'Data added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong!');
        }
    }

    //status update
    public function status(int $id): JsonResponse
    {
        $data = OurKeyHighlight::findOrFail($id);
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

    //edit
    public function edit($id)
    {
        // Find the record by id
        $item = OurKeyHighlight::find($id);

        if (!$item) {
            return redirect()->route('key-highlight.index')->with('error', 'Record not found.');
        }

        // Pass the item to the edit view
        return view('backend.layouts.our-key-highlight.edit', compact('item'));
    }

    //update
    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'title'         => 'nullable|string|max:255',
                'subtitle'      => 'nullable|string|max:500',
                'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'body_title'    => 'nullable|string|max:255',
                'icon'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'description'   => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Fetch the existing data using id
            $data = OurKeyHighlight::findOrFail($id);

            // Update fields
            $data->title        = $request->title;
            $data->subtitle     = $request->subtitle;
            $data->body_title   = $request->body_title;
            $data->description  = $request->description;

            // Handle the image upload
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($data->image) {
                    Helper::fileDelete($data->image);
                }

                // Upload the new image
                $imagePath = Helper::fileUpload($request->file('image'), 'OurKeyHighlight', time() . '_' . $request->file('image')->getClientOriginalName());
                $data->image = $imagePath;
            }

            // Handle the icon upload
            if ($request->hasFile('icon')) {
                // Delete the old icon if it exists
                if ($data->icon) {
                    Helper::fileDelete($data->icon);
                }

                // Upload the new icon
                $iconPath = Helper::fileUpload($request->file('icon'), 'OurKeyHighlight/icon', time() . '_' . $request->file('icon')->getClientOriginalName());
                $data->icon = $iconPath;
            }

            $data->save();

            return redirect()->route('key-highlight.index')->with('t-success', 'Record updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('key-highlight.index')->with('t-error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Remove the specified city content from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data = OurKeyHighlight::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.',
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete.',
            ]);
        }
    }
}
