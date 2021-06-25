<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index']]);
    }

    public function index()
    {
        $expense = Expense::Active()->get();
        return response(ExpenseResource::collection($expense), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'business_location_id' => 'required',
                'amount' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $expense = new Expense();
        $expense->business_id = auth()->user()->business_id;
        $expense->business_location_id = $request->business_location_id;
        $expense->expense_for = $request->expense_for;
        $expense->is_monthly_expense=$request->is_monthly_expense?1:0;
        $expense->amount = $request->amount;
        $expense->ref_no = $request->ref_no;
        $expense->exp_date = date("Y-m-d", strtotime($request->exp_date));
        $expense->exp_cat_id = $request->exp_cat_id;
        $expense->note = $request->note;
        $expense->created_by = auth()->user()->id;
        $expense->save();

        if (is_object($request->file)) {
            $file = $request->file;
            Helper::uploadFile($file, $expense, $expense->business_id);
        }

        return response(new ExpenseResource($expense), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return new ExpenseResource($expense);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        if ($request->has('is_monthly_expense')) {
            $expense->is_monthly_expense = $request->is_monthly_expense;
        }
        if ($request->has('amount')) {
            $expense->amount = $request->amount;
        }
        if ($request->has('ref_no')) {
            $expense->ref_no = $request->ref_no;
        }
        if ($request->has('exp_date')) {
            $expense->exp_date = date("Y-m-d", strtotime($request->exp_date));
        }
        if ($request->has('exp_cat_id') && $request->exp_cat_id !== 'null') {
            $expense->exp_cat_id = $request->exp_cat_id;
        }
        if ($request->has('note')) {
            $expense->note = $request->note;
        }

        $expense->save();

        return response(new ExpenseResource($expense), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::where('id', $id)->first();
        $expense->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
