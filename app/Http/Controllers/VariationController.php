<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductVariationResource;
use Illuminate\Http\Request;
use App\Models\Variation;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class VariationController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index']]);
    }

    public function index()
    {
        $pv = Variation::Active()->get();
        return response(ProductVariationResource::collection($pv), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required',
                'value'     => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $pv = new Variation();
        $pv->business_id = auth()->user()->business_id;
        $pv->name = $request->name;
        $pv->value = $request->value;
        $pv->save();

        return response(new ProductVariationResource($pv), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $pv = Variation::findOrFail($id);

        if ($request->has('name')) {
            $pv->name = $request->name;
        }
        if ($request->has('value')) {
            $pv->value = $request->value;
        }

        $pv->save();

        return response(new ProductVariationResource($pv), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $pv = Variation::where('id', $id)->first();
        $pv->delete();
        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
