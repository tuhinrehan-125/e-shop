<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\QuotationResource;
use App\Models\BusinessLocation;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    protected $business_location;

    public function __construct()
    {
        if (auth()->user()->hasRole('Admin')) {
            $this->business_location = auth()->user()->Business->Location->pluck('id');
        } else {
            $this->business_location = auth()->user()->locations->pluck('id');
        }
        $this->middleware('jwt', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotation = Quotation::whereIn('business_location_id', $this->business_location)->paginate(10);
        return QuotationResource::collection($quotation);
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
                'business_location_id'    => 'required',
                'customer_id' => 'required',
                'supplier_id' => 'required',
                'status' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $quotation = new Quotation;
            $business_location = BusinessLocation::findOrFail($request->business_location_id);
            $quotation->business_location_id = $business_location->id;
            $quotation->customer_id  = $request->customer_id;
            $quotation->supplier_id  = $request->supplier_id;
            $quotation->status = $request->status;
            $quotation->quotation_date = date("Y-m-d", strtotime($request->quotation_date));
            $quotation->discount = $request->discount;
            $quotation->tax = $request->tax;
            $quotation->shipping_cost = $request->shipping_cost;
            $quotation->note = $request->note;
            $quotation->created_by = auth()->user()->id;
            $quotation->updated_by = auth()->user()->id;
            $quotation->save();

            if (!empty($request->quotation_doc)) {
                $quotation_doc = $request->quotation_doc;
                Helper::uploadFile($quotation_doc, $quotation, $business_location->business_id);
            }

            $item_quantity = 0;
            $item_subtotal_price = 0;
            $afterTax = 0;
            foreach (json_decode($request->quotation_items) as $item) {
                QuotationItem::saveItems($quotation, $item);
                $item_quantity += $item->quantity;
                $item_subtotal_price += $item->subtotal;
            }
            $quotation->subtotal_cost = $item_subtotal_price;

            if ($quotation->tax > 0) {
                $taxInPercentage = ($quotation->tax / 100);
                $afterTax = $item_subtotal_price * $taxInPercentage;
            }

            $quotation->total_cost = ($item_subtotal_price + $afterTax  + $quotation->shipping_cost) - $quotation->discount;

            $quotation->save();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
        DB::commit();

        return response(new QuotationResource($quotation), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        return new QuotationResource($quotation);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quotation $quotation)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'business_location_id'    => 'required',
                'customer_id' => 'required',
                'supplier_id' => 'required',
                'status' => 'required'
            ]
        );
        
        DB::beginTransaction();
        try {
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()], 422);
            }
            if ($request->has('customer_id')) {
                $quotation->customer_id = $request->customer_id;
            }
            if ($request->has('supplier_id')) {
                $quotation->supplier_id = $request->supplier_id;
            }
            if ($request->has('status')) {
                $quotation->status = $request->status;
            }
            if ($request->has('quotation_date')) {
                $quotation->quotation_date = $request->quotation_date;
            }
            if ($request->has('discount')) {
                $quotation->discount = $request->discount;
            }
            if ($request->has('tax')) {
                $quotation->tax = $request->tax;
            }
            if ($request->has('shipping_cost')) {
                $quotation->shipping_cost = $request->shipping_cost;
            }
            if ($request->has('note')) {
                $quotation->note = $request->note;
            }
            $quotation->save();

            $item_subtotal_price = 0;
            $afterTax = 0;
            foreach (json_decode($request->quotation_items) as $item) {
                $existing_quotation_items = QuotationItem::where('quotation_id', $quotation->id)->where('product_id', $item->product_id)->where('variation_id', $item->variation_id)->first();
                if ($existing_quotation_items) {
                    $existing_quotation_items->quantity = $item->quantity;
                    $existing_quotation_items->unit_price = $item->purchase_price;
                    $existing_quotation_items->tax = $item->tax;
                    $existing_quotation_items->discount = $item->discount;
                    $existing_quotation_items->unit_id  = $item->unit;
                    $existing_quotation_items->total_price = $item->subtotal;
                    $existing_quotation_items->save();
                    $item_subtotal_price += $existing_quotation_items->total_price;
                } else {
                    QuotationItem::saveItems($quotation, $item);
                    $item_subtotal_price += $item->subtotal;
                }
            }
            $quotation->subtotal_cost = $item_subtotal_price;

            if ($quotation->tax > 0) {
                $taxInPercentage = ($quotation->tax / 100);
                $afterTax = $item_subtotal_price * $taxInPercentage;
            }

            $quotation->total_cost = ($item_subtotal_price + $afterTax  + $quotation->shipping_cost) - $quotation->discount;

            $quotation->save();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
        DB::commit();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quotation = Quotation::where('id', $id)->first();

        $quotation->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
