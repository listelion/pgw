<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Address;
use App\Product;

class RankController extends Controller
{
    protected $Ranks;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $product = $request->product;
        $ranks = Address::select(\DB::raw('addr_product, addr_send_name, addr_send_num1, addr_send_num2, addr_send_num3, SUM(addr_amount) as addr_amount'))
            ->where('deleted_yn', 'n')
            ->where('addr_gubun', '1')
            ->when($product, function ($query, $product) {
                return $query->where('addr_product', $product);
            })
            ->groupBy(\DB::raw('addr_product, addr_send_name, addr_send_num1, addr_send_num2, addr_send_num3'))
            ->orderBy('addr_amount','desc')
            ->get();

        foreach ($ranks as $rank){
            $rank->product_name = Product::where('id', $rank->addr_product)->value('name');
        }
        $product_lists = Product::get();
        return view('rank', [
            'ranks' => $ranks,
            'product_lists' => $product_lists,
            'product' => $product,
        ]);
    }

}
