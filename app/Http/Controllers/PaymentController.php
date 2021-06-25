<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Advance;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Client;
use App\Models\Bank;
use App\Models\Mode;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
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
        $orders = Order::orderBy('id','desc')->get();
        return response(PaymentResource::collection($orders), Response::HTTP_OK);
    }


    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'client_id'     => 'required',
                'select_mode'     => 'required',
                'amount'    => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $payment = new Payment();

        $payment->client_id = $request->client_id;
        $payment->order_id = $request->order_id;

        $payment->payment_amount = $request->amount;

        if ($request->select_mode == 'bKash') {
            $payment->select_mode = 'bKash';
            $payment->from_bKash = $request->from_bKash;
            $payment->to_bKash = $request->to_bKash;
        } elseif ($request->select_mode == 'Bank') {
            $payment->select_mode = 'Bank';
            $payment->bank_id = $request->bank_id;
            $payment->bank_code_id = $request->bank_code_id;
        } else {
            $payment->select_mode = 'Cash';
        }
        if ($request->adjust_advance > 0) {
            $advance = new Advance();
            $data = array(
                'advance_type' => 'taken',
                'client_id' => $request->client_id,
                'amount' => $request->adjust_advance,
                'payment_method' => $request->select_mode,
            );
            $advance->create($data);
        }
        $payment->adjust_advance = $request->adjust_advance;

        $payment->save();

        return response()->json(['success' => true, 'data' => $payment], 200);

        // /return response(new PaymentResource($payment), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {

        $payment = Payment::findOrFail($id);

        if ($request->has('client_id')) {
            $payment->client_id = $request->client_id;
        }
        if ($request->has('select_mode')) {
            $payment->select_mode = $request->select_mode;
        }
        if ($request->has('payment_amount')) {
            $payment->payment_amount = $request->payment_amount;
        }
        if ($request->has('adjust_advance')) {
            $payment->adjust_advance = $request->adjust_advance;
        }


        $payment->save();
        return response(new PaymentResource($payment), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $client = Payment::findOrFail($id);
        if ($client->delete_status == 1) {
            $client->delete_status = 0;
        } else {
            $client->delete_status = 1;
        }

        $client->save();
        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
