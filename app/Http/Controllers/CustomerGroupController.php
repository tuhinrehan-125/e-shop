<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerGroupResource;
use Illuminate\Http\Request;
use App\Models\CustomerGroup;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CustomerGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index']]);
    }

    public function index()
    {
        $customerGroup = CustomerGroup::Active()->get();
        return response(CustomerGroupResource::collection($customerGroup), Response::HTTP_OK);
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

        $customerGroup = new CustomerGroup();

        $customerGroup->business_id = auth()->user()->business_id;
        $customerGroup->created_by = auth()->user()->id;
        $customerGroup->name = $request->name;
        $customerGroup->percentage_value = $request->percentage_value;

        $customerGroup->save();

        return response(new CustomerGroupResource($customerGroup), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $customerGroup = CustomerGroup::findOrFail($id);

        if ($request->has('name')) {
            $customerGroup->name = $request->name;
        }
        if ($request->has('percentage_value')) {
            $customerGroup->percentage_value = $request->percentage_value;
        }

        $customerGroup->save();

        return response(new CustomerGroupResource($customerGroup), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $customerGroup = CustomerGroup::where('id', $id)->first();

        $customerGroup->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
