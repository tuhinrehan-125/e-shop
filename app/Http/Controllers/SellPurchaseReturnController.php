<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductVariationResource;
use App\Models\SalePurchaseReturn;
use App\Http\Resources\SalePurchaseReturnResource;
use App\Http\Resources\SellPurchaseReturnResource;
use App\Models\BusinessLocation;
use App\Models\LocationProductStock;
use App\Models\ProductVariation;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\PurchasePayment;
use App\Models\Sell;
use App\Models\SellItem;
use App\Models\SellPurchaseReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SellPurchaseReturnController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function getPosProducts()
    {
        $ProductVariation = ProductVariation::orderBy('name', 'asc')->paginate(15);
        return ProductVariationResource::collection($ProductVariation);
    }

    public function purchaseReturnList()
    {
        $b_location = Auth::user()->Business->Location->pluck('id');
        $purchases = Purchase::whereIn('business_location_id', $b_location)->get();
        $sell_purchase_return = [];
        foreach ($purchases as $purchase) {
            $sell_purchase_return = $purchase->return;
        }
        return response(SellPurchaseReturnResource::collection($sell_purchase_return), Response::HTTP_OK);
    }
    public function sellReturnList()
    {
        $b_location = Auth::user()->Business->Location->pluck('id');
        $purchases = Sell::whereIn('business_location_id', $b_location)->get();
        $sell_purchase_return = [];
        foreach ($purchases as $purchase) {
            $sell_purchase_return = $purchase->return;
        }
        return response(SellPurchaseReturnResource::collection($sell_purchase_return), Response::HTTP_OK);
    }

    /**
     * Store return purchase
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function returnPurchase(Request $request, $id)
    {

        DB::beginTransaction();
        try {

            $purchase = Purchase::findOrFail($id);

            foreach ($request->purchase_return as $return_item) {

                $purchased_items = PurchaseItem::where('purchase_id', $purchase->id)->where('product_id', $return_item['product_id'])->where('product_variation_id', $return_item['product_variation_id'])->first();
                if ($purchased_items) {
                    $purchased_items->returned_quantity += $return_item['quantity'];
                    $purchased_items->save();
                }
                $individual_total_amount = $purchased_items->total_price / $purchased_items->purchase_quantity;
                //save purchase return
                $purchase_return = $purchase->return()->create([
                    'business_id' => Auth::user()->business_id,
                    'contact_id' =>  $purchase->contact_id,
                    'business_location_id' => $purchase->business_location_id,
                    'product_id' =>  $return_item['product_id'],
                    'variation_id' => $return_item['product_variation_id'],
                    'return_quantity' => $return_item['quantity'],
                    'total_amount' => $return_item['quantity'] * $individual_total_amount,
                    'created_by' => Auth::user()->id,
                ]);

                LocationProductStock::decreaseProductStock($purchase_return->product_id, $purchase_return->variation_id, $purchase_return->return_quantity, $purchase_return->business_id, $purchase_return->business_location_id);
            }
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Purchase returned successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(), 'errLine' => $e->getLine()], 500);
        }
    }

    /**
     * Store return sell
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function returnSell(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $sell = Sell::findOrFail($id);

            foreach ($request->sell_return as $return_item) {

                $sold_item = SellItem::where('sell_id', $sell->id)->where('product_id', $return_item['product_id'])->where('variation_id', $return_item['product_variation_id'])->first();
                if ($sold_item) {
                    $sold_item->returned_quantity += $return_item['quantity'];
                    $sold_item->save();
                }
                $individual_total_amount = $sold_item->total_price / $sold_item->sell_quantity;
                //save purchase return
                $sell_return = $sell->return()->create([
                    'business_id' => Auth::user()->business_id,
                    'contact_id' =>  $sell->contact_id,
                    'business_location_id' => $sell->business_location_id,
                    'product_id' =>  $return_item['product_id'],
                    'variation_id' => $return_item['product_variation_id'],
                    'return_quantity' => $return_item['quantity'],
                    'total_amount' => $return_item['quantity'] * $individual_total_amount,
                    'created_by' => Auth::user()->id,
                ]);

                LocationProductStock::increaseProductStock($sell_return->product_id, $sell_return->variation_id, $sell_return->return_quantity, $sell_return->business_id, $sell_return->business_location_id);
            }
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Sell returned successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(), 'errLine' => $e->getLine()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalePurchaseReturn  $salePurchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function show(SalePurchaseReturn $salePurchaseReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalePurchaseReturn  $salePurchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(SalePurchaseReturn $salePurchaseReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalePurchaseReturn  $salePurchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalePurchaseReturn $salePurchaseReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalePurchaseReturn  $salePurchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalePurchaseReturn $salePurchaseReturn)
    {
        //
    }

    public function getProductTnfo($variation, $location)
    {
        $business_id = auth()->user()->business_id;

        $location_product_stock = LocationProductStock::where('business_id', $business_id)->where('product_variation_id', $variation)->where('location_id', $location)->first();
        try {
            $product_id = $location_product_stock['product_id'];
            $current_stock = $location_product_stock['qty_available'];
            if($current_stock<1){
                return response()->json(['success' => false, 'errmsg' => 'Item out of stock']);
            }
            $product_info = DB::table('product_variations')
                ->join('products', 'products.id', '=', 'product_variations.product_id')
                ->where('products.id', $product_id)
                ->where('product_variations.id', $variation)
                ->select(
                    'products.id as product_id',
                    'products.type as product_type',
                    'products.tax_type as product_tax_type',
                    'product_variations.name as product_name',
                    'product_variations.tax as product_tax',
                    'product_variations.sell_price as product_sell_price'
                )->first();
            if($product_info->product_tax_type=='exclusive'){
                $added_tax_price=$product_info->product_sell_price*$product_info->product_tax/100;
                $product_info->product_sell_price += $added_tax_price;
            }
            $product_info->current_stock = $current_stock;
            return response()->json(['success' => true, 'data' => $product_info]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'errmsg' => 'Item out of stock']);
        }
    }
}
