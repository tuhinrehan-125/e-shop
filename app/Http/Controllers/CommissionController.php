<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommissionResource;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commissions=Commission::all();

        return response(CommissionResource::collection($commissions), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'customer_id'    => 'required',
                'percentage' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $commission = new Commission();
        $commission->customer_id = $request->customer_id;
        $commission->percentage = $request->percentage;
        $commission->save();

        return response(new CommissionResource($commission), Response::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commission $commission)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'customer_id'    => 'required',
                'percentage' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $commission->customer_id = $request->customer_id;
        $commission->percentage = $request->percentage;
        $commission->save();

        return response()->json($commission, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        if($commission){
            $commission->delete();
            return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
        }
    }
}
