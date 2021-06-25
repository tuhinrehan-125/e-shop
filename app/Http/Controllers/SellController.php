<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\SellItemsResource;
use App\Http\Resources\SellResource;
use App\Models\BusinessLocation;
use App\Models\LocationProductStock;
use App\Models\Sell;
use App\Models\SellItem;
use App\Models\SellPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SellController extends Controller
{
    protected $business_location;

    public function __construct()
    {
        if(auth()->user()->hasRole('Admin'))
        {
            $this->business_location=auth()->user()->Business->Location->pluck('id');
        }else{
            $this->business_location=auth()->user()->locations->pluck('id');
        }   
        $this->middleware('jwt', ['except' => ['index']]);
    }

    public function index()
    {    
        $sells = Sell::whereIn('business_location_id',$this->business_location)->get();
        return response(SellResource::collection($sells), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'business_location_id'    => 'required',
                'customer_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
            $sell = new Sell();
            $business_location = BusinessLocation::findOrFail($request->business_location_id);
            $sell->business_location_id = $business_location->id;
            $sell->ref_no = $request->ref_no;
            $sell->contact_id = $request->customer_id;
            $sell->sell_status = $request->sell_status;
            $sell->sell_date = date("Y-m-d", strtotime($request->sell_date));
            $sell->sell_discount = $request->sell_discount;
            $sell->sell_tax = $request->sell_tax;
            $sell->shipping_cost = $request->shipping_cost;
            $sell->created_by = auth()->user()->id;
            $sell->updated_by = auth()->user()->id;
            $sell->save();

            if (!empty($sell->sell_doc)) {
                $sell_doc = $request->sell_doc;
                Helper::uploadFile($sell_doc, $sell, $business_location->business_id);
            }

            $item_sell_quantity = 0;
            $item_subtotal_price = 0;
            $afterTax=0;

            foreach (json_decode($request->sell_items) as $item) {
                $sell_item = SellItem::saveSellItems($sell, $item);
                $item->total_transaction_item=-$item->sell_quantity;
                $stockProduct= LocationProductStock::updateProductInStock($item,$business_location->id,$business_location->business_id);
                $item_sell_quantity += $item->sell_quantity;
                $item_subtotal_price += $item->subtotal;
            }
            $sell->total_sell_quantity = $item_sell_quantity;
            $sell->subtotal_cost = $item_subtotal_price;

            if($sell->sell_tax>0){
                $taxInPercentage = ($sell->sell_tax / 100);
                $afterTax = $item_subtotal_price * $taxInPercentage;
            }

            $sell->total_cost = ($item_subtotal_price + $afterTax  + $sell->shipping_cost) - $sell->sell_discount;

            $sell->save();

            if ($request->payment_amount != null) {
                $sell->payments()->create([
                    'payment_amount' => $request->payment_amount,
                    'payment_method' => $request->payment_method,
                    'payment_date' =>  date("Y-m-d", strtotime($request->payment_date?$request->payment_date:now()))
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(),'line' => $e->getLine()], 500);
        }
        DB::commit();

        return response(new SellResource($sell), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sell $sell)
    {
        return new SellResource($sell);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sell $sell)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'business_location_id'    => 'required',
                'customer_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
            if ($request->has('business_location_id')) {
                $sell->business_location_id = $request->business_location_id;
            }
            if ($request->has('customer_id')) {
                $sell->contact_id = $request->customer_id;
            }
            if ($request->has('sell_status')) {
                $sell->sell_status = $request->sell_status;
            }
            if ($request->has('sell_date')) {
                $sell->sell_date =date("Y-m-d", strtotime($request->sell_date));
            }
            if ($request->has('sell_discount')) {
                $sell->sell_discount = $request->sell_discount;
            }
            if ($request->has('sell_tax')) {
                $sell->sell_tax = $request->sell_tax;
            }
            if ($request->has('shipping_cost')) {
                $sell->shipping_cost = $request->shipping_cost;
            }
            if ($request->has('sell_discount')) {
                $sell->sell_discount = $request->sell_discount;
            }
            if ($request->has('note')) {
                $sell->sell_note = $request->note;
            }
            $sell->updated_by = auth()->user()->id;
            $sell->save();

           
            if (!empty($sell->sell_doc)) {
                $business_location = BusinessLocation::findOrFail($request->business_location_id);
                $sell_doc = $request->sell_doc;
                Helper::uploadFile($sell_doc, $sell, $business_location->business_id);
            }

            $item_sell_quantity = 0;
            $item_subtotal_price = 0;
            $afterTax=0;

            foreach (json_decode($request->sell_items) as $item) {
                $existing_sell_item = SellItem::where('sell_id', $sell->id)->where('product_id', $item->product_id)->where('variation_id', $item->variation_id)->first();
                if ($existing_sell_item) {
                    $existing_sell_item->sell_quantity = $item->sell_quantity;
                    $existing_sell_item->unit_id  = $item->unit;
                    $existing_sell_item->discount = $item->discount;
                    $existing_sell_item->total_price = $item->subtotal;
                    $existing_sell_item->save();
                    $item_sell_quantity += $existing_sell_item->sell_quantity;
                    $item_subtotal_price += $existing_sell_item->total_price;
                } else {
                    SellItem::saveSellItems($sell, $item);
                    $item_sell_quantity += $item->sell_quantity;
                    $item_subtotal_price += $item->subtotal;
                }
                // $stockProduct= LocationProductStock::updateProductInStock($item,$business_location->id,$business_location->business_id);
                
            }
            $sell->total_sell_quantity = $item_sell_quantity;
            $sell->subtotal_cost = $item_subtotal_price;

            if($sell->sell_tax>0){
                $taxInPercentage = ($sell->sell_tax / 100);
                $afterTax = $item_subtotal_price * $taxInPercentage;
            }

            $sell->total_cost = ($item_subtotal_price + $afterTax  + $sell->shipping_cost) - $sell->sell_discount;

            $sell->save();

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(),'line' => $e->getLine()], 500);
        }
        DB::commit();
    }

    public function viewPayment(Request $request)
    {
        $sellid=$request->id;
        $sell=Sell::findOrFail($sellid);
        $all_payments=$sell->payments;
        return response()->json(['data' => $all_payments],200);
    }


    //For payment
    public function addPayment(Request $request, $id)
    {
        $sell = Sell::findOrFail($id);

        $previousPayment = $sell->payments->sum('payment_amount');

        if ($sell->total_cost >= ($previousPayment + $request->payment_amount)) {
            $newPayment = $sell->payments()->create([
                'payment_amount' => $request->payment_amount,
                'payment_method' => $request->payment_method,
                'payment_date' =>  date("Y-m-d", strtotime($request->payment_date ? $request->payment_date : now()))
            ]);

            $sell->payment_status = "partial";
            if ($sell->total_cost == ($previousPayment + $request->payment_amount)) {
                $sell->payment_status = "paid";
            }
            $sell->save();

            return response(new SellResource($sell), Response::HTTP_OK);
        } elseif ($sell->total_cost < ($previousPayment + $request->payment_amount)) {
            return response()->json(['success' => false, 'message' => 'You can not pay more than the original amount!'], 400);
        }
    }

    public function sellItemsList(Request $request)
    {
        $sellid = $request->sell_id;
        $sell = Sell::findOrFail($sellid);
        $all_items = $sell->sellItems;
        return response(SellItemsResource::collection($all_items), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sell = Sell::find($id);

        $sell->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
