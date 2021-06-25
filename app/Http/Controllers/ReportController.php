<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentResource;
use App\Models\Collection;
use App\Models\Expense;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function expenseReport(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;
        $category = $request->category;
        if (!empty($start) && !empty($end)) {
            $startdate = Carbon::parse($start);
            $enddate = Carbon::parse($end);
        } else {
            $startdate = Carbon::now()->subDays(30);
            $enddate = Carbon::now();
        }
        $expenses=Expense::whereBetween('created_at', [$startdate, $enddate]);
         if(!empty($category)){
            $expenses->where('exp_cat_id',$category);
        }
        return response(ExpenseResource ::collection($expenses->get()), Response::HTTP_OK);
        // if(!empty($category)){
        //     $amount->where('exp_cat_id',$category);
        // }
        // $res= $amount->sum('amount');

        // return response()->json(['success' => true, 'amount' => $res], 200);
    }


    public function collectionReport(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;
        if (!empty($start) && !empty($end)) {
            $startdate = Carbon::parse($start);
            $enddate = Carbon::parse($end);
        } else {
            $startdate = Carbon::now()->subDays(30);
            $enddate = Carbon::now();
        }
        return response(CollectionResource::collection(OrderProduct::whereBetween('created_at', [$startdate, $enddate])->get()), Response::HTTP_OK);
    }

    public function paymentReport(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;
        if (!empty($start) && !empty($end)) {
            $startdate = Carbon::parse($start);
            $enddate = Carbon::parse($end);
        } else {
            $startdate = Carbon::now()->subDays(30);
            $enddate = Carbon::now();
        }
        return response(PaymentResource ::collection(Order::whereBetween('created_at', [$startdate, $enddate])->get()), Response::HTTP_OK);
    }

    public function salesReport(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;
        if (!empty($start) && !empty($end)) {
            $startdate = Carbon::parse($start);
            $enddate = Carbon::parse($end);
        } else {
            $startdate = Carbon::today();
            $enddate = Carbon::tomorrow();
        }
        return response(OrderResource::collection(OrderProduct::whereBetween('created_at', [$startdate, $enddate])->get()), Response::HTTP_OK);

    }
}
