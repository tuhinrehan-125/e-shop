<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentMethodResource;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PaymentMethodController extends Controller
{

    public function index()
    {
        $paymentMethod = PaymentMethod::where('delete_status', 1)->get();

        return response(PaymentMethodResource::collection($paymentMethod), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $paymentMethod = new PaymentMethod();
        $paymentMethod->name = $request->name;
        $paymentMethod->bank_name = $request->bank_name;
        $paymentMethod->bank_acc_no = $request->bank_acc_no;
        $paymentMethod->bkash_no = $request->bkash_no;

        $paymentMethod->save();
        return response(new PaymentMethodResource($paymentMethod), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        if ($request->has('name')) {
            $paymentMethod->name = $request->name;
        }
        if ($request->has('bank_name')) {
            $paymentMethod->bank_name = $request->bank_name;
        }
        if ($request->has('bank_acc_no')) {
            $paymentMethod->bank_acc_no = $request->bank_acc_no;
        }
        if ($request->has('bkash_no')) {
            $paymentMethod->bkash_no = $request->bkash_no;
        }

        $paymentMethod->save();
        return response(new PaymentMethodResource($paymentMethod), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        if ($paymentMethod->delete_status == 1) {
            $paymentMethod->delete_status = 0;
        } else {
            $paymentMethod->delete_status = 1;
        }

        $paymentMethod->save();
        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
