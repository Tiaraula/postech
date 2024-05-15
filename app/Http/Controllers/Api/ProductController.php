<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product:: paginate ($request->perPage);        
        return response()->json ($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'qty' => 'required',
            'selling_price' => 'required',
            'buying_price' => 'required',
            'product_type_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $product = Product::create([
            'product_name' => $request->product_name,
            'qty' => $request->qty,
            'selling_price' => $request->selling_price,
            'buying_price' => $request->buyying_price,
            'product_type_id' => $request->product_type_id,
        ]);
        return response()->json([
            'message' => 'Ruangan successfully created',
            'ruangan' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $product_types = ProductType::all();
        return view('products.edit', compact('product_types', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required',
            'qty' => 'required',
            'selling_price' => 'required',
            'buying_price' => 'required',
            'product_type' => 'required',
        ]);

        $product->product_name = $request->product_name;
        $product->qty = $request->qty;
        $product->selling_price = $request->selling_price;
        $product->buying_price = $request->buying_price;
        $product->product_type_id = $request->product_type;
        $product->save();

        return redirect()->route('products.index')->withSuccess('Great! You have sucessfully Update '.$product->product_name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->withSuccess('Great! You have sucessfully Deleted '.$product->product_name);
    }
}
