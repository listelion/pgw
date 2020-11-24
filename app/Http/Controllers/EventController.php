<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Event;
use App\Http\Requests;

class EventController extends Controller
{
    protected $addresses;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $status = $request->status;
        $addresses = Event::where('addr_gubun','2')->orderBy('addr_send_date', 'desc')->get();
        if($status > 0) {
            $addresses = Event::where('addr_status', $status)->where('addr_gubun','2')->orderBy('addr_send_date', 'asc')->get();
        }
        return view('event', [
            'addresses' => $addresses,
            'name' => $request->user()->name,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'send_name' => 'required|max:10',
            'send_addr' => 'required|max:255',
            'send_addr2' => 'required|max:255',
            'send_num1' => 'required|max:4',
            'send_num2' => 'required|max:4',
            'send_num3' => 'required|max:4',
            'reci_name' => 'required|max:10',
            'reci_num1' => 'required|max:3',
            'reci_num2' => 'required|max:4',
            'reci_num3' => 'required|max:4',
            'reci_product' => 'required|max:20',
            'reci_senddate' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/address')
                ->withInput()
                ->withErrors($validator);
        }

        $addresses = new Address();
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
        $addresses->addr_product = $request->send_product;
        $addresses->addr_send_date = $request->send_date;
        $addresses->addr_gubun = '2';
        $addresses->save();

        return redirect('/address');
        // Create The Task...
    }

    public function edit($id)
    {
        $address = Event::Where(
            'id', $id)->get();

        return view('/event_view', [
            'address' => $address,
            'id' => $id,
        ]);
    }

    public function jang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'send_jang' => 'required|max:13',
        ]);

        if ($validator->fails()) {
            return redirect('/event/'.$id)
                ->withInput()
                ->withErrors($validator);
        }

        $address = Event::find($id);
        $address->addr_send_jang = $request->send_jang;
        $address->addr_status = 2;
        $send_num = $address->addr_send_num1."-".$address->addr_send_num2."-".$address->addr_send_num3;
        if($address->addr_user_id == 1) {
            $reci_num = "010-3074-2314";
        }
        else{$reci_num = "010-3516-4921";}
        $address->save();

        $gubun = 2;

        SendMsg($send_num, $reci_num, $request->send_jang, $gubun);
        Telegram(urlencode("발송처리 되었습니다. \n받는사람 : " . $address->addr_send_name . "\n상품 : ".$address->addr_product."\n발송장번호 : ".$request->send_jang));
        return redirect('/event/'.$id);
        // Create The Task...
    }
    public function destroy(Request $request, Address $addresses)
    {
        $addresses->delete();
        return redirect('/address');
    }
}
