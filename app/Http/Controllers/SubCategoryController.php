<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubCategoryResource;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SubCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index']]);
    }

    public function index()
    {
        $SubCategory = SubCategory::with('Category')->where('delete_status', 1)->get();

        return response(SubCategoryResource::collection($SubCategory), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'category_id' => 'required',
                'name'     => 'required',

            ]
        );
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error' => $validator->errors()],422);
        }

        $SubCategory = new SubCategory();
        $SubCategory->name = $request->name;
        $SubCategory->category_id = $request->category_id;
        $SubCategory->description = $request->description;
        $SubCategory->save();

        return response(new SubCategoryResource($SubCategory), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {

        $SubCategory = SubCategory::findOrFail($id);

        if ($request->has('category_id')) {
            $SubCategory->category_id = $request->category_id;
        }
        if ($request->has('name')) {
            $SubCategory->name = $request->name;
        }
        if ($request->has('description')) {
            $SubCategory->description = $request->description;
        }

        $SubCategory->save();

        return response(new SubCategoryResource($SubCategory), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $SubCategory = SubCategory::findOrFail($id);
        $SubCategory->delete_status = 0;

        $SubCategory->save();

        return response()->json(['success'=>true,'message'=>'Deleted successfully'],204);
    }
}
