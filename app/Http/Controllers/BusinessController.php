<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Models\Currency;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business = Business::find($request->id);
        return response(new BusinessResource($business), Response::HTTP_OK);
    }

    public function saveSettingsAndLocation(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'business_id' => 'required',
                    'currency_id' => 'required',
                    'business_locations.*.name'    => 'required|unique:business_locations,name',
                ],
                [
                    'currency_id.required' => 'Currency is required',
                    'business_locations.*.name.required' => 'Business name is required',
                    'business_locations.*.name.unique' => 'Business location name is already taken'
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            if (!empty($request['currency_id'])) {
                $business = Business::findOrFail($request->business_id);
                $business->currency_id = $request->currency_id;
                $business->save();
            }

            if (!empty($request['business_locations'])) {
                foreach ($request->business_locations as $location) {
                    Business::addLocation($location, $request->business_id);
                }
            }

            return response()->json(['success' => true, 'data' => $business], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage()], 500);
        }
    }

    /**
     * currency list
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllCurrency(Request $request)
    {
        $cur = Currency::all();
        return response()->json(['success' => true, 'data' => $cur], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $business = Business::findOrFail($id);

        if ($request->has('name')) {
            $business->name = $request->name;
        }
        if ($request->has('currency_id')) {
            $business->currency_id = $request->currency_id;
        }
        if ($request->has('time_zone')) {
            $business->time_zone = $request->time_zone;
        }
        if (is_object($request->logo)) {
            $logo = $request->logo;
            Helper::uploadFile($logo, $business, $business->id);
        }
        $business->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        //
    }
}
