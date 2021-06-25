<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockTransferResource;
use App\Models\LocationProductStock;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class StockTransferController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('jwt', ['except' => ['index']]);
    // }

    public function index()
    {
        $stocktransfer = StockTransfer::Active()->get();
        return response(StockTransferResource::collection($stocktransfer), Response::HTTP_OK);
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
                'from_location' => 'required',
                'to_location' => 'required',
                'status' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
            $stocktransfer = new StockTransfer();
            $stocktransfer->business_id = Auth::user()->business_id;
            $stocktransfer->from_location = $request->from_location;
            $stocktransfer->to_location = $request->to_location;
            $stocktransfer->ref_no = $request->ref_no;
            $stocktransfer->status = $request->status;
            $stocktransfer->shipping_cost = $request->shipping_cost;
            $stocktransfer->note = $request->note;
            $stocktransfer->total = $request->total;
            $stocktransfer->created_by  = Auth::user()->id;
            $stocktransfer->updated_by  = Auth::user()->id;
            $stocktransfer->save();

            //save stock transfer items and transfer stock
            foreach ($request->transfer_items as $item) {
                StockTransferItem::saveItems($item, $stocktransfer);
                LocationProductStock::increaseProductStock(
                    $item['product_id'],
                    $item['variation_id'],
                    $item['quantity'],
                    $stocktransfer['business_id'],
                    $stocktransfer['to_location']
                );
                LocationProductStock::decreaseProductStock(
                    $item['product_id'],
                    $item['variation_id'],
                    $item['quantity'],
                    $stocktransfer['business_id'],
                    $stocktransfer['from_location']
                );
            }

            DB::commit();
            return response()->json(['success' => true, 'nessage' => 'Stock Transfered successfulyy'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    /**
     * Show the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(StockTransfer $stockTransfer)
    {
        return new StockTransferResource($stockTransfer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockTransfer $stockTransfer)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_location' => 'required',
                'to_location' => 'required',
                'status' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }
      
        DB::beginTransaction();
        try {
            $stockTransfer->to_location = $request->to_location;
            $stockTransfer->status = $request->status;
            $stockTransfer->shipping_cost = $request->shipping_cost;
            $stockTransfer->note = $request->note;
            $stockTransfer->total = $request->total;
            $stockTransfer->updated_by  = Auth::user()->id;
            $stockTransfer->save();

            //save stock transfer items and transfer stock
            foreach ($request->transfer_items as $item) {
                $existing_item = StockTransferItem::where('stock_transfer_id', $stockTransfer->id)->where('product_id', $item['product_id'])->where('variation_id', $item['variation_id'])->first();
                if ($existing_item) {
                    $old_qty = $existing_item->quantity;
                    $existing_item->quantity = $item['quantity'];
                    $existing_item->unit_id = $item['unit'];
                    $existing_item->unit_price = $item['purchase_price'];
                    $existing_item->save();

                    if ($item['quantity'] > $old_qty) {
                        $qty = $item['quantity'] - $old_qty;
                        $item['quantity'] = $qty;
                    } else {
                        $qty = $old_qty - $item['quantity'];
                        $item['quantity'] = $qty;
                    }
                } else {
                    StockTransferItem::saveItems($item, $stockTransfer);
                }
                LocationProductStock::increaseProductStock(
                    $item['product_id'],
                    $item['variation_id'],
                    $item['quantity'],
                    $stockTransfer['business_id'],
                    $stockTransfer['to_location']
                );
                LocationProductStock::decreaseProductStock(
                    $item['product_id'],
                    $item['variation_id'],
                    $item['quantity'],
                    $stockTransfer['business_id'],
                    $stockTransfer['from_location']
                );
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
        DB::commit();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $StockTransfer = StockTransfer::find($id);

        $StockTransfer->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
