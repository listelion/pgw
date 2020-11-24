<?php

namespace App\Http\Controllers;
use App\Inven;
use App\Product;
use App\Code;
use Illuminate\Http\Request;

class InvenController extends Controller
{
    protected $invens;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $invens = Inven::where('deleted_yn', 'n')
            ->get();
        $products = Product::where('deleted_yn', 'n')
        ->get();

        return view('inven', [
            'invens' => $invens,
            'products' => $products,
        ]);
    }

    public function write(Request $request)
    {
        $products = Product::where('deleted_yn', 'n')
            ->get();

        return view('inven_write', [
            'products' => $products,
        ]);
    }

    public function edit($id)
    {
        $inven = Inven::find($id);

        return view('/inven', [
            'inven' => $inven,
        ]);
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jago' => 'required',
            'content' => 'required',
            'product' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/inven_write')
                ->withInput()
                ->withErrors($validator);
        }

        $inven = new Inven;
        $inven->product = $request->product;
        $inven->jago = $request->jago;
        $inven->content = $request->content;
        $inven->save();

        return redirect('/inven');
        // Create The Task...
    }

    public function destroy(Request $request, Address $addresses)
    {
        $addresses->delete();
        return redirect('/address');
    }
}
