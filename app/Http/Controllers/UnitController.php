<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnitResource;
use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UnitController extends Controller
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
        $unit = Unit::Active()->Parent()->get();
        return response(UnitResource::collection($unit));
    }

    public function allUnits()
    {
        $unit = Unit::Active()->get();
        return response(UnitResource::collection($unit));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $unit = new Unit();

        $unit->name = $request->name;
        $unit->short_name = $request->short_name;
        if ($request->has('parent_id')) {
            $unit->parent_id = $request->parent_id;
        } else {
            $unit->parent_id = 0;
        }
        $unit->business_id = auth()->user()->business_id;
        $unit->short_name = $request->short_name;
        $unit->operator = $request->operator;
        $unit->value = $request->value;
        $unit->save();

        return response(new UnitResource($unit), Response::HTTP_CREATED);
    }

    public function getSubUnits(Unit $unit)
    {
        return response(UnitResource::collection($unit->name), Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        if ($request->has('name')) {
            $unit->name = $request->name;
        }
        if ($request->has('short_name')) {
            $unit->short_name = $request->short_name;
        }
        if ($request->has('parent_id')) {
            $unit->parent_id = $request->parent_id;
        } else {
            $unit->parent_id = 0;
        }
        if ($request->has('operator')) {
            $unit->operator = $request->operator;
        }
        if ($request->has('value')) {
            $unit->value = $request->value;
        }

        $unit->save();

        return response(new UnitResource($unit), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $unit = Unit::where('id', $id)->first();

        $unit->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
