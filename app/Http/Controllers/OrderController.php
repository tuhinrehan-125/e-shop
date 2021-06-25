<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Advance;
use App\Models\Category;
use App\Models\Commission;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    //

    public function index()
    {
        $order = Order::where('delete_status', 1)->paginate(10);

        return response(OrderResource::collection($order), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $lastOrder = Order::orderBy('id', 'desc')->first();
        $invoice_no = 1200;
        if ($lastOrder) {
            $invoice_no = $lastOrder->invoice_no + 1;
        }
        DB::beginTransaction();
        try {
            $order = Order::create([
                'invoice_no' => $invoice_no,
                'commission' => $request->commission,
                'client_id' => $request->client,
                'advance_payout' => $request->advance_payout,
                'grand_total' => $request->grand_total,
                'total' => $request->total_price,
                'status' => $request->type == 'invoice' ? 'pending' : 'complete'
            ]);
            if ($order) {
                foreach ($request->products as $product) {
                    $product = OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $product['product_id'],
                        'customer_id' => $product['customer_id'],
                        'product_price' => $product['price'],
                        'quantity' => $product['qty'],
                        'quantity_name' => $product['qtymethod'],
                        'payment_type' => $product['ptype'],
                        'total' => $product['total']
                    ]);
                }
            }
            $setting= Setting::first();
            $arot_com=$setting->arot_commission;
            $bazar_com=$setting->bazar_commission;

            $subtotal= $request->sub_total;
            $arot_com_amount=$this->percentAmount($subtotal,$arot_com);
            $bazar_com_amount=$this->percentAmount($subtotal,$bazar_com);

            $commission=new Commission();
            $commission->arot_com_income=$arot_com_amount;
            $commission->bazar_com_income=$bazar_com_amount;
            $commission->save();

            if ($request->advance_payout > 0) {
                $advance = new Advance();

                $advance->client_id = $request->client;
                $advance->amount =  $request->advance_payout;
                $advance->payment_method = 'Cash';
                $advance->advance_type = 'taken';
                $advance->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false,'errmsg'=>$e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(['success' => true,'order'=>$order], 200);
    }

    public function posProducts()
    {
        $cats =  Category::where('delete_status', 1)->get();

        $pos_products = $cats->map(function ($cat) {
            return array(
                'category' => $cat->name,
                'products' => $this->productInfo($cat->Products)
            );
        });

        return response()->json(['success' => true, 'data' => $pos_products], 200);
    }

    public function productInfo($item)
    {
        return ProductResource::collection($item);
    }

    public function percentAmount($amount,$percent)
    {
        return $amount*($percent/100);
    }
}
