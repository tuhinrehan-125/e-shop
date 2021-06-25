<?php

namespace App\Http\Controllers;

use App\Http\Resources\OpeningStockQtyResource;
use App\Models\OpeningStockQty;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class OpeningStockQtyController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index']]);
    }

    public function index()
    {
        $osq = OpeningStockQty::all();
        return response(OpeningStockQtyResource::collection($osq), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'quantity'     => 'required',
                'price'     => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $osq = new OpeningStockQty();

        $osq->business_id = auth()->user()->business_id;

        $osq->quantity = $request->quantity;
        $osq->price = $request->price;

        $osq->created_by = auth()->user()->id;

        $osq->save();

        return response(new OpeningStockQtyResource($osq), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OpeningStockQty  $openingStockQty
     * @return \Illuminate\Http\Response
     */
    public function show(OpeningStockQty $openingStockQty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OpeningStockQty  $openingStockQty
     * @return \Illuminate\Http\Response
     */
    public function edit(OpeningStockQty $openingStockQty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OpeningStockQty  $openingStockQty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OpeningStockQty $openingStockQty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OpeningStockQty  $openingStockQty
     * @return \Illuminate\Http\Response
     */
    public function destroy(OpeningStockQty $openingStockQty)
    {
        //
    }
}
