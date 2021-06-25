<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenseCategoryResource;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ExpenseCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index']]);
    }

    public function index()
    {
        $expenseCategory = ExpenseCategory::Active()->get();
        return response(ExpenseCategoryResource::collection($expenseCategory), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name'    => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $expenseCategory = new ExpenseCategory();
        $expenseCategory->business_id = auth()->user()->business_id;
        $expenseCategory->name = $request->name;
        $expenseCategory->code = $request->code;

        $expenseCategory->save();

        return response(new ExpenseCategoryResource($expenseCategory), Response::HTTP_CREATED);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'    => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }
        $expenseCategory = ExpenseCategory::findOrFail($id);

        if ($request->has('name')) {
            $expenseCategory->name = $request->name;
        }
        if ($request->has('code')) {
            $expenseCategory->code = $request->code;
        }

        $expenseCategory->save();

        return response(new ExpenseCategoryResource($expenseCategory), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expensecat = ExpenseCategory::where('id', $id)->first();

        $expensecat->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
