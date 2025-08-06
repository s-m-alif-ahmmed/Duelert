<?php

namespace App\Http\Controllers\Web\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
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
            $data = Blog::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($data) {
                    $user = $data->user->name;
                    return $user;
                })
                ->addColumn('title', function ($data) {
                    $title = Str::limit($data->title, 30);
                    return $title . (strlen($data->title) > 30 ? '...' : '');
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
                                <a href="' . route('blog.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>
                                 <a href="' . route('blog.show', ['id' => $data->id]) . '" type="button" class="btn btn-success fs-14 text-white" title="View">
                                    <i class="fe fe-eye"></i>
                                </a>

                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['user', 'title','image', 'status', 'action'])
                ->make();
        }
        return view('backend.layouts.blog.index');
    }

    /**
     * Show the form for creating a new dynamic page content.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backend.layouts.blog.create');
    }

    /**
     * Store a newly created dynamic page content in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */

    public function store(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'title'        => 'required|string|max:255',
                'description'  => 'required|string',
                'image'        => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:5120',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = new Blog();
            $data->user_id      = auth()->id();
            $data->title        = $request->title;
            $data->description  = $request->description;

            if ($request->hasFile('image')) {
                $imagePath = Helper::fileUpload($request->file('image'), 'Blog', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $data->image = $imagePath;
                }
            }

            $data->save();

            return redirect()->route('blog.index')->with('t-success', 'Blog saved successfully');
        } catch (\Exception $e) {
            return redirect()->route('blog.index')->with('t-error', 'Blog creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified dynamic page content.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $data = Blog::find($id);
        return view('backend.layouts.Blog.edit', compact('data'));
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
        try {
            // ✅ Validation
            $validator = Validator::make($request->all(), [
                'title'        => 'required|string|max:255',
                'description'  => 'required|string',
                'image'        => 'nullable|image|mimes:jpeg,jpg,png,svg,webp|max:3048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // ✅ Manually Fetch Blog Using ID
            $blog = Blog::findOrFail($id);

            // ✅ Update Data
            $blog->title       = $request->title;
            $blog->description = $request->description;

            // ✅ New Image Upload (Old Image Delete)
            if ($request->hasFile('image')) {
                Helper::fileDelete($blog->image); // old image delete

                $blog->image = Helper::fileUpload(
                    $request->file('image'),
                    'Blog',
                    time() . '_' . $request->file('image')->getClientOriginalName()
                );
            }

            $blog->save();

            return redirect()->route('blog.index')->with('t-success', 'Blog updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('blog.index')->with('t-error', 'Blog update failed: ' . $e->getMessage());
        }
    }


    public function show($id)
{
    try {
        // ✅ Fetch the Blog by ID
        $data = Blog::findOrFail($id);

        // ✅ Return the view with blog data
        return view('backend.layouts.Blog.show', compact('data'));
    } catch (\Exception $e) {
        // If blog not found, redirect with error
        return redirect()->route('blog.index')->with('t-error', 'Blog not found.');
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
        $data = Blog::findOrFail($id);
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
            $data = Blog::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Blog deleted successfully.',
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the Blog.',
            ]);
        }
    }
}
