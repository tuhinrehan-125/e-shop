<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function updateSettings(Request $request)
    {

        $setting = Setting::first();
        if (!$setting) {
            Setting::create($request->all());
        } else {
            $setting->arot_commission = $request->arot_commission;
            $setting->bazar_commission = $request->bazar_commission;
            $setting->save();
        }
        return response()->json(['success' => true, 'message' => 'Setting updated successfully']);
    }

    public function index()
    {
        $setting = Setting::first();
        $lastOrder = Order::orderBy('id', 'desc')->first();
        $invoice_no = 1200;
        if ($lastOrder) {
            $invoice_no = $lastOrder->invoice_no + 1;
        }
        if (!$setting) {
            return response()->json(['success' => true, 'data' => []]);
        } else {
            return response()->json(['success' => true, 'setting' => $setting,'invoice_no'=>$invoice_no]);
        }
    }
}
