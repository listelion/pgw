<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Invoice;
use App\Sms;
use App\Product;
use App\Code;
use App\Closing;
use App\Http\Requests;

class InvoiceController extends Controller
{
    protected $addresses;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $gubun = $request->gubun;
        $status = $request->status;
        $s_date = $request->s_date;
        $e_date = $request->e_date;
        $name = $request->name;
        $addresses = Invoice::when($status, function ($query, $status) {
                return $query->where('addr_status', $status);})
            ->when($name, function ($query, $name) {
                return $query->where('addr_send_name', 'like', "%".$name."%");
            })
            ->when($gubun, function ($query, $gubun) {return $query->where('addr_gubun', $gubun);})
            ->when($user_id, function ($query, $user_id) {return $query->where('addr_user_id', $user_id);})
            ->when($s_date, function ($query, $s_date) {
                return $query->where('addr_send_date', '>=', $s_date);
            }, function ($query) {
                return $query->where('addr_send_date', '>=', date("Y-m-01"));
            })
            ->when($e_date, function ($query, $e_date) {
                return $query->where('addr_send_date', '<=', $e_date);
            })
            ->where('deleted_yn', 'n')
            ->orderBy('addr_send_date', 'asc')
            ->orderBy('addr_reci_name', 'asc')
            ->get();
        
        foreach($addresses as $address){
            $address->courier_name = Code::where('code', $address->addr_courier)->value('content');
        }
        
        $sum_boxs = Invoice::select(\DB::raw('addr_product, addr_amount, Count(addr_amount) as amount'))
                ->when($status, function ($query, $status) {return $query->where('addr_status', $status);})
                ->when($gubun, function ($query, $gubun) {return $query->where('addr_gubun', $gubun);})
                ->when($user_id, function ($query, $user_id) {return $query->where('addr_user_id', $user_id);})
                ->when($s_date, function ($query, $s_date) {
                    return $query->where('addr_send_date', '>=', $s_date);
                })
                ->when($e_date, function ($query, $e_date) {
                    return $query->where('addr_send_date', '<=', $e_date);
                })
            ->groupBy('addr_product')
            ->where('deleted_yn', 'n')
            ->groupBy('addr_product', 'addr_amount')
            ->orderBy('addr_product', 'asc')
            ->get();

        foreach ($sum_boxs as $sum_box){
            $sum_box->product_name = Product::where('id', $sum_box->addr_product)->value("name");
        }

        return view('invoice', [
            'addresses' => $addresses,
            'name' => $request->user()->name,
            'status' => $request->status,
            'user_id' => $request->user_id,
            'gubun' => $request->gubun,
            's_date' => $request->s_date,
            'e_date' => $request->e_date,
            'sum_boxs' => $sum_boxs,
        ]);
    }

    public function edit($id)
    {
        $address = Invoice::find($id);
        $address->product_name = Product::where('id', $address->addr_product)->value('name');
        $temp = Closing::where('address_id', $id)->value('shop');
        $address->shop = Code::where('code', $temp)->value('content');
        $address->addr_courier_name = Code::where('code', $address->addr_courier)->value('content');


        $sms = Sms::Where(
            'invoice_id',$id)->get();

        return view('/invoice_view', [
            'address' => $address,
            'id' => $id,
            'sms' => $sms,
        ]);
    }

    public function jang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'send_jang' => 'required|max:13',
        ]);

        if ($validator->fails()) {
            return redirect('/invoice/'.$id)
                ->withInput()
                ->withErrors($validator);
        }

        $address = Invoice::find($id);
        $address->addr_send_jang = $request->send_jang;
        $address->addr_status = 2;
        $address->save();

        $address->addr_courier_name = Code::where('code', $address->addr_courier)->value('content');
        $address->product_name = Product::where('id', $address->addr_product)->value('name');

//        Telegram(urlencode("발송처리 되었습니다. \n받는사람 : " . $address->addr_send_name . "\n상품 : ".$address->product_name."\n발송장번호 : ".$address->addr_courier_name." ".$request->send_jang));
        return redirect('/invoice/'.$id);
        // Create The Task...
    }
    public function sendMessage(Request $request, $id)
    {
        $address = Invoice::find($id);
        $address->product_name = Product::where('id', $address->addr_product)->value('name');
        $address->addr_courier_name = Code::where('code', $address->addr_courier)->value('content');

        if($request->select == 1){
            $send_num = $address->addr_send_num1."-".$address->addr_send_num2."-".$address->addr_send_num3;
        }
        else{
            $send_num = $address->addr_reci_num1."-".$address->addr_reci_num2."-".$address->addr_reci_num3;
        }
        if($address->addr_user_id == 1) {
            $reci_num = "010-3074-2314";
        }
        else{$reci_num = "010-3516-4921";}

        $ret = SendMsg($address->addr_send_name, $send_num, $reci_num, $address->addr_send_jang, $address->addr_gubun, $address->product_name, $address->addr_amount,$address->addr_courier_name);
        print_r($ret);

        $sms = new Sms();
        $sms->user_id = $request->user()->id;
        $sms->invoice_id = $id;
        $sms->send_num = $send_num;
        $sms->reci_num = $reci_num;
        $sms->send_jang = $address->addr_send_jang;
        if($ret['CodeMsg'] == "Success!!") {
            $sms->send_yn = "Y";
        }
        $sms->save();

        return redirect('/invoice/'.$id);
    }

    public function send(Request $request){

        $validator = Validator::make($request->all(), [
            'send_num' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/invoice/')
                ->withInput()
                ->withErrors($validator);
        }

        $send_nums = $request->send_num;
        foreach($send_nums as $k => $v){
            $address = Invoice::find($k);
            $address->addr_send_jang = $v;
            $address->addr_status = 2;
            $address->save();
        }

        return redirect('/invoice?status=2');
    }
    
}
