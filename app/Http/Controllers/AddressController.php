<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Address;
use App\Helper;
use App\User;
use App\Closing;
use App\Code;
use App\Product;
use App\Http\Requests;

class AddressController extends Controller
{
    protected $addresses;


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user_list = User::get();
        $products = Product::orderBy('position', 'asc')->get();
        $codelist_shop = Code::where('class', 1)
            ->orderBy('code', 'asc')
            ->get();
        $codelist_couriers = Code::where('class', 21)
            ->orderBy('code', 'asc')
            ->get();
        return view('address', [
            'name' => $request->user()->name,
            'gubun' => $request->addr_gubun,
            'products' => $products,
            'codelist_shop' => $codelist_shop,
            'codelist_couriers' => $codelist_couriers,
            'user_list' => $user_list,
            'user_id' => $request->user()->id,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $products = Product::orderBy('position', 'asc')->get();
        $codelist_shop = Code::where('class', 1)
            ->orderBy('code', 'asc')
            ->get();
        $codelist_couriers = Code::where('class', 21)
            ->orderBy('code', 'asc')
            ->get();
        $address = Address::find($id);
        $closing = Closing::where('address_id', $id)->first();
        $user_list = User::get();
        return view('address_edit', [
            'id' => $id,
            'products' => $products,
            'codelist_shop' => $codelist_shop,
            'codelist_couriers' => $codelist_couriers,
            'address' => $address,
            'closing' => $closing,
            'user_list' => $user_list,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'send_name' => 'required|max:10',
            'send_addr' => 'required|max:255',
            'send_num1' => 'required|max:4',
            'send_num2' => 'required|max:4',
            'send_num3' => 'required|max:4',
            'reci_name' => 'required|max:10',
            'reci_num1' => 'required|max:3',
            'reci_num2' => 'required|max:4',
            'reci_num3' => 'required|max:4',
            'addr_product' => 'required',
            'addr_send_gubun' => 'required',
            'addr_amount' => 'required',
            'addr_date' => 'required',
            'closing_value' => 'required',
            'closing_shop' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/address')
                ->withErrors($validator)
                ->withInput();
        }

        $addresses = new Address();
        $closing = new Closing();
        $closing->shop = $request->closing_shop;
        if($request->addr_gubun == '1'){
            $closing->gubun = "02001";
        }
        else{
            $closing->gubun = "02002";
        }

        $closing->value = $request->closing_result;
        $closing->user_id = $request->addr_user_id;
        $closing->date = date($request->addr_date);
        $addresses->addr_user_id = $request->addr_user_id;
        $addresses->addr_send_name = $request->send_name;
        $addresses->addr_send_addr = $request->send_addr;
        $addresses->addr_send_addr2 = $request->send_addr2;
        $addresses->addr_send_num1 = $request->send_num1;
        $addresses->addr_send_num2 = $request->send_num2;
        $addresses->addr_send_num3 = $request->send_num3;
        $addresses->addr_reci_name = $request->reci_name;
        $addresses->addr_reci_num1 = $request->reci_num1;
        $addresses->addr_reci_num2 = $request->reci_num2;
        $addresses->addr_reci_num3 = $request->reci_num3;
        $addresses->addr_product = $request->addr_product;
        $addresses->addr_send_date = $request->addr_date;
        $addresses->addr_send_gubun = $request->addr_send_gubun;
        $addresses->addr_gubun = $request->addr_gubun;
        $addresses->addr_amount = $request->addr_amount;
        $addresses->addr_courier = $request->addr_courier;
        $addresses->addr_memo = $request->addr_memo;
        $addresses->deposit_yn = $request->deposit_yn;
        $addresses->save();
        $addresses->closing()->save($closing);

        $product_name = Product::where('id', $request->addr_product)->value('name');

//        Telegram(urlencode("새로운 송장이 등록 되었습니다. \n받는사람 : " . $request->send_name . "\n주소 : " .$request->send_addr." ".$request->send_addr2."\n전화번호 : " . $request->send_num1."-".$request->send_num2."-".$request->send_num3."\n보내는사람 : ".$request->reci_name."\n보낸연락처 : ".$request->reci_num1."-".$request->reci_num2."-".$request->reci_num3."\n상품 : ".$product_name." ".$request->addr_amount."박스"."\n발송예정일 : ".$request->addr_date));
        return redirect('/invoice?status=1');
        // Create The Task...
    }

    public function edit_store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'send_name' => 'required|max:10',
            'send_addr' => 'required|max:255',
            'send_num1' => 'required|max:4',
            'send_num2' => 'required|max:4',
            'send_num3' => 'required|max:4',
            'reci_name' => 'required|max:10',
            'reci_num1' => 'required|max:3',
            'reci_num2' => 'required|max:4',
            'reci_num3' => 'required|max:4',
            'addr_product' => 'required',
            'addr_send_gubun' => 'required',
            'addr_amount' => 'required',
            'addr_date' => 'required',
            'closing_value' => 'required',
            'closing_shop' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/address')
                ->withErrors($validator)
                ->withInput();
        }

        $addresses = Address::find($id);
        $closing = Closing::where('address_id', $id)->first();
        $closing->shop = $request->closing_shop;
        if($request->addr_gubun == '1'){
            $closing->gubun = "02001";
        }
        else{
            $closing->gubun = "02002";
        }
        $closing->value = $request->closing_result;
        $closing->user_id = $request->addr_user_id;
        $closing->date = date($request->addr_date);
        $addresses->addr_user_id = $request->addr_user_id;
        $addresses->addr_send_name = $request->send_name;
        $addresses->addr_send_addr = $request->send_addr;
        $addresses->addr_send_addr2 = $request->send_addr2;
        $addresses->addr_send_num1 = $request->send_num1;
        $addresses->addr_send_num2 = $request->send_num2;
        $addresses->addr_send_num3 = $request->send_num3;
        $addresses->addr_reci_name = $request->reci_name;
        $addresses->addr_reci_num1 = $request->reci_num1;
        $addresses->addr_reci_num2 = $request->reci_num2;
        $addresses->addr_reci_num3 = $request->reci_num3;
        $addresses->addr_product = $request->addr_product;
        $addresses->addr_send_date = $request->addr_date;
        $addresses->addr_send_gubun = $request->addr_send_gubun;
        $addresses->addr_gubun = $request->addr_gubun;
        $addresses->addr_amount = $request->addr_amount;
        $addresses->addr_courier = $request->addr_courier;
        $addresses->addr_memo = $request->addr_memo;
        $addresses->deposit_yn = $request->deposit_yn;
        $addresses->save();
        $addresses->closing()->save($closing);

        $product_name = Product::where('id', $request->addr_product)->value('name');

        //Telegram(urlencode("새로운 송장이 등록 되었습니다. \n받는사람 : " . $request->send_name . "\n주소 : " .$request->send_addr." ".$request->send_addr2."\n전화번호 : " . $request->send_num1."-".$request->send_num2."-".$request->send_num3."\n보내는사람 : ".$request->reci_name."\n보낸연락처 : ".$request->reci_num1."-".$request->reci_num2."-".$request->reci_num3."\n상품 : ".$product_name." ".$request->addr_amount."박스"."\n발송예정일 : ".$request->addr_date));
        return redirect('/invoice?status=1');
        // Create The Task...
    }

    public function delete(Request $request, $id)
    {
        $addresses = Address::find($id);
        $closing = Closing::where('address_id', $id)->first();
        $closing->deleted_yn = 'y';
        $addresses->deleted_yn = 'y';
        $addresses->save();
        $addresses->closing()->save($closing);

        return redirect('/invoice');
    }

    public function label(Request $request, $id)
    {
        $addresses = Address::find($id);
        $addresses->label_yn = 'y';
        $addresses->save();

        return redirect('/invoice?status=1');
    }
}
