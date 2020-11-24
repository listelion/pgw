<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Deposit;
use App\Product;
use App\Closing;
use App\Code;
use App\Http\Requests;

class DepositController extends Controller
{
    protected $addresses;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $search_text = $request->search_text;
        $yn = "n";
        if(boolval($request->yn) > 0){$yn =$request->yn;}
        $addresses = Deposit::where('deposit_yn', $yn)
            ->where('deleted_yn', 'n')
            ->when($user_id, function ($query, $user_id) {return $query->where('addr_user_id', $user_id);})
            ->orderBy('addr_send_date', 'desc')
            ->get();
        foreach ($addresses as $address){
            $address->shop_code = Closing::where('address_id', $address->id)->value('shop');
            $address->shop_name = Code::where('code', $address->shop_code)->value('content');
        }
        if($request->shop_code > 0) {
            $addresses = $addresses->where('shop_code', $request->shop_code);
            $addresses->all();
        }

        $codelist_shop = Code::where('class', 1)
            ->orderBy('code', 'asc')
            ->get();

        return view('deposit', [
            'addresses' => $addresses,
            'codelist_shop' => $codelist_shop,
            'user_id' => $user_id,
            'request' => $request,
        ]);
    }

    public function view($id)
    {
        $address = Deposit::Where(
            'id', $id)->get();

        foreach ($address as $address){
            $address->addr_product = Product::where('id', $address->addr_product)->value('name');
            $address->shop_code = Closing::where('address_id', $address->id)->value('shop');
            $address->shop_name = Code::where('code', $address->shop_code)->value('content');
        }

        return view('/deposit_view', [
            'address' => $address,
            'id' => $id,
        ]);
    }

    public function deposit_yn(Request $request, $id)
    {
        $address = Deposit::find($id);
        $address->deposit_yn = $request->deposit_yn;
        $address->save();

        $address->addr_product = Product::where('id', $address->addr_product)->value('name');

//        Telegram(urlencode("입금 상태 변경 되었습니다. \n받는사람 : " . $address->addr_send_name . "\n상품 : ".$address->addr_product."\n입금여부 : 완료"));
        return redirect('/deposit');
        // Create The Task...
    }

    public function destroy(Request $request, Address $addresses)
    {
        $addresses->delete();
        return redirect('/address');
    }
}
