<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubCategoryResource;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function index()
    {
        $categories = Category::Active()->get();
        return response(CategoryResource::collection($categories), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:categories,name',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = new Category;

        if (!empty($request->parent_id)) {
            //for sub-category
            $category->parent_id = $request->parent_id;
        } else {
            //for category
            $category->parent_id = 0;
        }

        $category->business_id = auth()->user()->business_id;
        $category->name = $request->name;
        $category->short_code = $request->short_code;

        $category->save();

        return response(new CategoryResource($category), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        if (!empty($request->parent_id)) {
            //for sub-category
            $category->parent_id = $request->parent_id;
        } else {
            //for category
            $category->parent_id = 0;
        }
        if ($request->has('name')) {
            $category->name = $request->name;
        }
        if ($request->has('short_code')) {
            $category->short_code = $request->short_code;
        }

        $category->save();

        return response(new CategoryResource($category), Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $category = Category::where('id', $id)->first();

        $category->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
