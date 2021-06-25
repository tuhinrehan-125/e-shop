<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductVariationResource;
use App\Http\Resources\SingleProductResource;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\OpeningStockQty;
use App\Models\ProductVariation;
use App\Models\SubCategory;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function index(Request $request)
    {
        $name=$request->name;
        $category_id=$request->category_id;
        $unit_id=$request->unit_id;

        $product = Products::Active();

        if($name){
            $product->where('name', 'like', '%' . $name . '%');
        }if($category_id){
            $product->where('category_id', $category_id);
        }
        if($unit_id){
            $product->where('unit_id', $unit_id);
        }
        $results=$product->orderBy('name','asc')->paginate(10);

        return ProductResource::collection($results);
        //return response(ProductResource::collection($product), Response::HTTP_OK);
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name'    => 'required',
                'category_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
            $product = new Products();
            $product->business_id = auth()->user()->business_id;
            $product->name = $request->name;
            $product->type = $request->type;
            $product->unit_id = $request->unit_id;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->enable_stock = $request->enable_stock;
            $product->alert_quantity = $request->alert_quantity;
            $product->tax_type = $request->tax_method;
            $product->sku = Products::generateSku($request->sku);
            $product->product_description = $request->product_description;
            $product->weight = $request->weight;
            $product->barcode_type = $request->barcode_type;
            $product->created_by = auth()->user()->id;
            $product->save();
            if (!empty($request->images)) {
                $pro_image = $request->images;
                foreach ($pro_image as $key => $value) {
                    Helper::uploadImage($value, $product, $product->business_id);
                }
            }
            if ($product->type == 'single') {
                Products::createSingleProductVariation($product, $request->purchase_price, $request->sell_price, $request->tax);
            } elseif ($product->type == 'variable') {
                if (!empty($request->product_variation)) {
                    $product_variations = $request->product_variation;
                    foreach ($product_variations as $product_variation) {
                        Products::createVariableProductVariations($product, $product_variation);
                    }
                }
            }

            if ($request->add_opening_stock == 1) {
                foreach ($request->opening_stocks as $opening_stock) {
                    OpeningStockQty::saveOpeningStock($product, $opening_stock);
                }
            }
            DB::commit();
            return response(new ProductResource($product), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function show(Products $product)
    {
        return new SingleProductResource($product);
    }


    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        DB::beginTransaction();
        try {

            if ($request->has('name')) {
                $product->name = $request->name;
            }
            if ($request->has('type')) {
                $product->type = $request->type;
            }
            if ($request->has('unit_id')) {
                $product->unit_id = $request->unit_id;
            }
            if ($request->has('brand_id')) {
                $product->brand_id = $request->brand_id;
            }
            if ($request->has('category_id')) {
                $product->category_id = $request->category_id;
            }
            if ($request->has('enable_stock')) {
                $product->enable_stock = $request->enable_stock;
            }
            if ($request->has('tax_method')) {
                $product->tax_type = $request->tax_method;
            }
            if ($request->has('alert_quantity')) {
                $product->alert_quantity = $request->alert_quantity;
            }
            if ($request->has('sku')) {
                if ($request->sku !== $product->sku) {
                    Products::generateSku($request->sku);
                }
            }
            if ($request->has('product_description')) {
                $product->product_description = $request->product_description;
            }
            if ($request->has('weight')) {
                $product->weight = $request->weight;
            }
            if ($request->has('price')) {
                $product->price = $request->price;
            }
            if ($request->has('barcode_type')) {
                $product->barcode_type = $request->barcode_type;
            }

            $product->save();


            //update product variations

            if ($product->type == 'single') {
                Products::updateSingleProductVariation($request->variation_id, $product, $request->purchase_price, $request->sell_price, $request->tax);
            } elseif ($product->type == 'variable') {
                if (!empty($request->product_variation)) {
                    $product_variations = $request->product_variation;
                    foreach ($product_variations as $product_variation) {
                        Products::updateVariableProductVariations($product, $product_variation);
                    }
                }
            }

            //create or update opening stock
            if ($request->add_opening_stock == 1) {
                $opening_stocks = json_decode($request->opening_stocks);
                if (count($opening_stocks) > 0) {
                    foreach ($opening_stocks as $opening_stock) {
                        $existing_opening_stock = OpeningStockQty::find($opening_stock->id);
                        OpeningStockQty::updateOpeningStock($product, $opening_stock, $existing_opening_stock);
                    }
                } else {
                    foreach ($opening_stocks as $opening_stock) {
                        OpeningStockQty::saveOpeningStock($product, $opening_stock);
                    }
                }
            }
            DB::commit();
            return response(new ProductResource($product), Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    protected function storeImg($image, $product)
    {
        $extname = $image->getClientOriginalExtension();
        $img_name = substr(md5(uniqid(rand(1, 6))) . microtime(true), 0, 15) . '.' . $extname;
        $image->move(public_path('images'), $img_name);
        $product->image = $img_name;
    }

    public function destroy($id)
    {
        $product = Products::where('id', $id)->first();

        $product->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }

    public function searchByCategoryAndBrand(Request $request)
    {
        $business_id = auth()->user()->business_id;
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;

        $searhQ = ProductVariation::join('products', 'product_variations.product_id', '=', 'products.id')
            ->where('products.business_id', $business_id);

            if($category_id){
                $searhQ->where('products.category_id', $category_id);
            }
            if($brand_id){
                $searhQ->where('products.brand_id', $brand_id);
            }
            $searhQ->select(
                'products.id as product_id',
                'product_variations.id as variation_id',
                'product_variations.name as name',
                'product_variations.name as variation',
                'product_variations.sub_sku as sub_sku',
                'product_variations.purchase_price as purchase_price',
                'product_variations.sell_price as sell_price',
                'product_variations.tax as tax',
                'product_variations.created_at as created_at',
            );
            $results= $searhQ->orderBy('product_variations.name','asc')->paginate(15);
            return ProductVariationResource::collection($results);
    }

    public function productSearch(Request $request)
    {
        $business_id = auth()->user()->business_id;
        $location_id = $request->location_id;

        $keyword = $request->name;

        $searhQ = Products::leftJoin('product_variations', 'product_variations.product_id', '=', 'products.id')
            ->where(function ($query) use ($keyword) {
                $query->where('products.name', 'like', '%' . $keyword . '%');
                $query->orWhere('sku', 'like', '%' . $keyword . '%');
                $query->orWhere('sub_sku', 'like', '%' . $keyword . '%');
            });
        if ($location_id) {
            $searhQ->leftJoin('location_product_stocks', 'location_product_stocks.product_variation_id', '=', 'product_variations.id')
                ->where('location_product_stocks.location_id', $location_id);
        }
        $searhQ->where('products.business_id', $business_id)
            ->whereNull('products.deleted_at')
            ->whereNull('product_variations.deleted_at')
            ->select(
                'products.id as product_id',
                'products.unit_id',
                'products.name',
                'products.type',
                'products.tax_type',
                'products.sku as product_sku',
                'product_variations.id as variation_id',
                'product_variations.name as variation_name',
                'product_variations.name as variation',
                'product_variations.sub_sku as sub_sku',
                'product_variations.purchase_price as purchase_price',
                'product_variations.sell_price as sell_price',
                'product_variations.tax as tax',
            );
        if ($location_id) {
            $searhQ->addSelect('location_product_stocks.qty_available as qty_available');
        }

        $products = $searhQ->get();

        $result = [];
        if (!empty($products)) {
            foreach ($products as $key => $value) {
                if ($value->type == 'single') {
                    $result[] = [
                        'product_id' =>  $value->product_id,
                        'product_sku' => $value->product_sku,
                        'unit' => $value->unit_id,
                        'allunit' => $value->unit->subUnits ? $value->unit->subUnits->map(function ($value, $key) {
                            $sub_units = [];
                            if ($value->parent) {
                                $sub_units[] = [
                                    'id' => $value->parent->id,
                                    'name' => $value->parent->name,
                                    'value' => $value->parent->value
                                ];
                            }
                            $sub_units[] = [
                                'id' => $value->id,
                                'name' => $value->name,
                                'value' => $value->value
                            ];
                            return $sub_units;
                        })->first() : [],
                        'product' => $value->name . '-' . $value->product_sku,
                        'variation_id' => $value->variation_id,
                        'purchase_price' => $value->purchase_price,
                        'sell_price' => $value->tax_type == 'inclusive' ? $value->sell_price : $value->sell_price + ($value->sell_price * $value->tax) / 100,
                        'tax' => $value->tax_type == 'inclusive' ? null : $value->tax,
                        'qty_available' => $value->qty_available ? $value->qty_available : null
                    ];
                } else {
                    $result[] = [
                        'product_id' =>  $value->product_id,
                        'unit' => $value->unit_id,
                        'allunit' => $value->unit->subUnits ? $value->unit->subUnits->map(function ($value, $key) {
                            $sub_units = [];
                            if ($value->parent) {
                                $sub_units[] = [
                                    'id' => $value->parent->id,
                                    'name' => $value->parent->name,
                                    'value' => $value->parent->value
                                ];
                            }
                            $sub_units[] = [
                                'id' => $value->id,
                                'name' => $value->name,
                                'value' => $value->value
                            ];
                            return $sub_units;
                        })->first() : [],
                        'variation_id' => $value->variation_id,
                        'product' => $value->name . '(' . $value->variation_name . ')' . '-' . $value->sub_sku,
                        'purchase_price' => $value->purchase_price,
                        'sell_price' => $value->tax_type == 'inclusive' ? $value->sell_price : $value->sell_price + ($value->sell_price * $value->tax) / 100,
                        'tax' => $value->tax_type == 'inclusive' ? null : $value->tax,
                        'qty_available' => $value->qty_available ? $value->qty_available : null
                    ];
                }
            }
        }
        return json_encode($result);
    }
}
