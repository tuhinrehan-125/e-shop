<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business = Business::find($request->id);
        $business_locations=$business->Location;
        return response()->json($business_locations,200);
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
                'name' => 'required|unique:business_locations,name',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'zip_code' => 'required',
                'business_id' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $bl= new BusinessLocation;
        $bl->name=$request->name;
        $bl->business_id=$request->business_id;
        $bl->country=$request->country;
        $bl->state=$request->state;
        $bl->city=$request->city;
        $bl->zip_code=$request->zip_code;
        $bl->mobile=$request->mobile;
        $bl->email=$request->email;
        $bl->alternate_number=$request->alternate_number;
        $bl->save();

        return response()->json(['success' => true, 'message' => 'Business Location Created Successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessLocation  $businessLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessLocation $businessLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessLocation  $businessLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessLocation $businessLocation)
    {
        //
    }
}
