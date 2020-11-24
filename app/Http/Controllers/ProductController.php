<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Product;

use App\Http\Requests;

class ProductController extends Controller
{

    protected $products;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $products = Product::orderBy('position', 'asc')->get();

        return view('product', [
            'products' => $products,
        ]);
    }

    public function write()
    {
        $id = 0;
        return view('product_write', [
            'id' => $id,
        ]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('/product_write', [
            'product' => $product,
            'id' => $id,
        ]);
    }

    public function write_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'price' => 'required',
            'parcel' => 'required',
            'parcel_max' => 'required',
            'position' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/product_write')
                ->withInput()
                ->withErrors($validator);
        }

        $products = new Product();
        $products->name = $request->name;
        $products->price = $request->price;
        $products->parcel = $request->parcel;
        $products->parcel_max = $request->parcel_max;
        $products->position = $request->position;
        $products->save();

        return redirect('/product');
        // Create The Task...
    }

    public function edit_store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'price' => 'required',
            'parcel' => 'required',
            'parcel_max' => 'required',
            'position' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/product_write')
                ->withInput()
                ->withErrors($validator);
        }

        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->parcel = $request->parcel;
        $product->parcel_max = $request->parcel_max;
        $product->position = $request->position;
        $product->save();

        return redirect('/product');
        // Create The Task...
    }
}
