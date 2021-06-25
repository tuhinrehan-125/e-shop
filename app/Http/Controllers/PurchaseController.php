<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\PurchaseItemsResource;
use App\Http\Resources\PurchaseResource;
use App\Models\BusinessLocation;
use App\Models\LocationProductStock;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchasePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PurchaseController extends Controller
{
//     public function __construct()
//     {
//         $this->middleware('jwt', ['except' => ['index']]);
//     }

    public function index()
    {
        $business_location = Auth::user()->Business->Location->pluck('id');
        $purchase = Purchase::whereIn('business_location_id', $business_location)->get();
        return response(PurchaseResource::collection($purchase), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'business_location_id' => 'required',
                'supplier_id' => 'required',
                'purchase_date' => 'required',
                'purchase_status' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {

            $purchase = new Purchase();

            $business_location = BusinessLocation::findOrFail($request->business_location_id);
            $purchase->business_location_id = $business_location->id;
            $purchase->contact_id = $request->supplier_id;
            $purchase->purchase_status = $request->purchase_status;
            $purchase->purchase_date = date("Y-m-d", strtotime($request->purchase_date));
            $purchase->purchase_discount = $request->purchase_discount;
            $purchase->purchase_tax = $request->purchase_tax;
            $purchase->shipping_charge = $request->shipping_cost;
            $purchase->shipping_details = $request->shipping_details;
            $purchase->created_by = auth()->user()->id;
            $purchase->updated_by = auth()->user()->id;
            $purchase->save();

            if (!empty($request->purchase_doc)) {
                $purchase_doc = $request->purchase_doc;
                Helper::uploadFile($purchase_doc, $purchase, $business_location->business_id);
            }

            $item_purchase_quantity = 0;
            $item_subtotal_price = 0;
            $afterTax = 0;


            foreach (json_decode($request->purchase_items) as $item) {
                $purchase_item = PurchaseItem::savePurchaseItem($purchase->id, $item);
                $stockProduct = LocationProductStock::saveProductInStock($item, $business_location->id, $business_location->business_id);
                $item_purchase_quantity += $purchase_item->purchase_quantity;
                $item_subtotal_price += $purchase_item->total_price;
            }

            $purchase->total_purchase_quantity = $item_purchase_quantity;
            $purchase->subtotal_cost = $item_subtotal_price;

            if ($purchase->purchase_tax > 0) {
                $taxInPercentage = ($purchase->purchase_tax / 100);
                $afterTax = $item_subtotal_price * $taxInPercentage;
            }

            $purchase->total_cost = ($item_subtotal_price + $afterTax + $purchase->shipping_charge) - $purchase->purchase_discount;

            $purchase->save();

            if ($request->payment_amount != null) {
                $purchase->payments()->create([
                    'payment_amount' => $request->payment_amount,
                    'payment_method' => $request->payment_method,
                    'payment_date' =>  date("Y-m-d", strtotime($request->payment_date ? $request->payment_date : now()))
                ]);
                //PurchasePayment::savePurchasePayment($purchase->id, $request->payment_amount, $request->payment_type, $request->payment_date);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage()], 500);
        }
        DB::commit();

        return response(new PurchaseResource($purchase), Response::HTTP_CREATED);
    }

    
    public function show(Purchase $purchase)
    {
        return new PurchaseResource($purchase);
    }


    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        try {

            $purchase = Purchase::findOrFail($id);
            $business_location = BusinessLocation::findOrFail($request->business_location_id);
            if ($request->has('supplier_id')) {
                $purchase->contact_id = $request->supplier_id;
            }
            if ($request->has('purchase_status')) {
                $purchase->purchase_status = $request->purchase_status;
            }
            if ($request->has('purchase_date')) {
                $purchase->purchase_date = date("Y-m-d", strtotime($request->purchase_date));
            }
            if ($request->has('purchase_discount')) {
                $purchase->purchase_discount = $request->purchase_discount;
            }
            if ($request->has('purchase_tax')) {
                $purchase->purchase_tax = $request->purchase_tax;
            }
            if ($request->has('shipping_cost')) {
                $purchase->shipping_charge = $request->shipping_cost;
            }
            if ($request->has('shipping_details')) {
                $purchase->shipping_details = $request->shipping_details;
            }
            $purchase->updated_by = auth()->user()->id;

            $purchase->save();

            $item_purchase_quantity = 0;
            $item_subtotal_price = 0;
            $afterTax = 0;

            foreach (json_decode($request->purchase_items) as $store_items) {
                $existing_purchased_items = PurchaseItem::where('purchase_id', $purchase->id)->where('product_id', $store_items->product_id)->where('product_variation_id', $store_items->variation_id)->first();
                if ($existing_purchased_items) {
                    $old_qty=$existing_purchased_items->purchase_quantity;
                    $existing_purchased_items->purchase_quantity = $store_items->quantity;
                    $existing_purchased_items->purchase_price = $store_items->purchase_price;
                    $existing_purchased_items->purchase_price = $store_items->purchase_price;
                    $existing_purchased_items->tax = $store_items->tax;
                    $existing_purchased_items->discount = $store_items->discount;
                    $existing_purchased_items->save();
                    $item_purchase_quantity += $existing_purchased_items->quantity;
                    $item_subtotal_price += $existing_purchased_items->total_price;

                    $diff_purchase_qty=$store_items->quantity - $old_qty;
                    $store_items->total_transaction_item= $diff_purchase_qty;
                    
                    LocationProductStock::updateProductInStock($store_items,$business_location->id,$business_location->business_id);
                } else {
                    $purchase_item = PurchaseItem::savePurchaseItem($purchase->id,$store_items);
                    LocationProductStock::saveProductInStock($store_items, $business_location->id, $business_location->business_id);
                    $item_purchase_quantity += $purchase_item->purchase_quantity;
                    $item_subtotal_price += $purchase_item->total_price;
                }
            }
            $purchase->total_purchase_quantity = $item_purchase_quantity;
            $purchase->subtotal_cost = $item_subtotal_price;

            if ($purchase->purchase_tax > 0) {
                $taxInPercentage = ($purchase->purchase_tax / 100);
                $afterTax =  $item_subtotal_price * $taxInPercentage;
            }

            $purchase->total_cost = ($item_subtotal_price + $afterTax + $purchase->shipping_cost) -  $purchase->purchase_discount;
            
            $purchase->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(),'line' => $e->getLine()], 500);
        }


        return response(new PurchaseResource($purchase), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $purchase = Purchase::where('id', $id)->first();

        $purchase->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }

    //For payment
    public function addPayment(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        $previousPayment = $purchase->payments->sum('payment_amount');

        if ($purchase->total_cost >= ($previousPayment + $request->payment_amount)) {
            $newPayment = $purchase->payments()->create([
                'payment_amount' => $request->payment_amount,
                'payment_method' => $request->payment_method,
                'payment_date' =>  date("Y-m-d", strtotime($request->payment_date ? $request->payment_date : now()))
            ]);

            $purchase->payment_status = "partial";
            if ($purchase->total_cost == ($previousPayment + $request->payment_amount)) {
                $purchase->payment_status = "paid";
            }
            $purchase->save();

            return response(new PurchaseResource($purchase), Response::HTTP_OK);
        } elseif ($purchase->total_cost < ($previousPayment + $request->payment_amount)) {
            return response()->json(['success' => false, 'message' => 'You can not pay more than the original amount!'], 400);
        }
    }

    public function viewPayment(Request $request)
    {
        $purchaseid = $request->id;
        $purchase = Purchase::findOrFail($purchaseid);
        $all_payments = $purchase->payments;
        return response()->json(['data' => $all_payments], 200);
    }

    public function purchaseItemsList(Request $request)
    {
        $purchaseid = $request->purchase_id;
        $purchase = Purchase::findOrFail($purchaseid);
        $all_items = $purchase->purchaseItems;
        return response(PurchaseItemsResource::collection($all_items), Response::HTTP_OK);
    }

    public function returnPurchase(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
        $business_location = BusinessLocation::findOrFail($request->business_location_id);
        $purchase->business_location_id = $business_location->id;
    }

    public function getContacts()
    {
        $contacts = Contact::get();
        return \response()->json($contacts);
    }

    public function getBusinessLocations()
    {
        $locations = BusinessLocation::get();
        return \response()->json($locations);
    }

    public function getProducts(Request $request)
    {
        $name = $request->name;
        $products = Products::where('name', 'LIKE', "%$name%")->get();
        return \response()->json($products);
    }


}
