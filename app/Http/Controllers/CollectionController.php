<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\Mode;
use App\Models\Collection;
use App\Models\OrderProduct;
use Collator;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CollectionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index']]);
    }

    public function index()
    {
        $orderProducts = OrderProduct::orderBy('id','desc')->get();

        return response(CollectionResource::collection($orderProducts), Response::HTTP_OK);
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'customer_id'     => 'required',
                'payment_method'     => 'required',
                'amount'    => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error' => $validator->errors()],422);
        }

        $collection = new Collection();

        $collection->customer_id = $request->customer_id;
        $collection->payment_method = $request->payment_method;
        $collection->order_product_id = $request->order_product_id;
        $collection->amount = $request->amount;

        $collection->save();
        $orderProducts = OrderProduct::orderBy('id','desc')->get();
        return response(CollectionResource::collection($orderProducts), Response::HTTP_OK);
    }


    public function update(Request $request, $id)
    {

        $collection = Collection::findOrFail($id);

        if ($request->has('customer_id')) {
            $collection->customer_id = $request->customer_id;
        }
        if ($request->has('payment_method')) {
            $collection->payment_method = $request->payment_method;
        }
        if ($request->has('amount')) {
            $collection->amount = $request->amount;
        }
        $collection->save();

        return response(new CollectionResource($collection), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);
        if ($collection->delete_status == 1) {
            $collection->delete_status = 0;
        } else {
            $collection->delete_status = 1;
        }

        $collection->save();
        return response()->json(['success'=>true,'message'=>'Deleted successfully'],204);
    }


    public function customerDueMoney(Request $request)
    {
        $customer_id= $request->customer;
        $customer=Customer::find($customer_id);
        $dueamount=$customer->OrderProduct()->where('payment_type','Bokeya')->sum('total');
        return response()->json(['success'=>true,'dueamount'=>round($dueamount)],200);
    }
}
