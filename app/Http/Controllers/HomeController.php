<?php

namespace App\Http\Controllers;
use App\Address;
use App\User;
use App\Product;
use App\Closing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ago_month = date("Y-m-d", strtotime("-1 month", time()));
        $today = date("Y-m-d");
        $this_month = date("Y-m-d", mktime(0, 0, 0, intval(date('m')), 1, intval(date('Y'))  ));

        $address_today_count = Address::select(\DB::raw('COUNT(id) as count'))
            ->where('addr_send_date', $today)
            ->where('deleted_yn', 'n')
            ->value('count');

        $address_today_count1 = Address::select(\DB::raw('COUNT(id) as count'))
            ->where('addr_send_date', '<=', $today)
            ->where('addr_status', 1)
            ->where('deleted_yn', 'n')
            ->value('count');

        $address_today_count2 = Address::select(\DB::raw('COUNT(id) as count'))
            ->where('addr_send_date', $today)
            ->where('addr_status', 2)
            ->where('deleted_yn', 'n')
            ->value('count');

        $address_today = Address::where('addr_send_date', $today)
            ->where('deleted_yn', 'n')
            ->get();

        $address_reser_count = Address::select(\DB::raw('COUNT(id) as count'))
            ->where('addr_send_date', '>', $today)
            ->where('deleted_yn', 'n')
            ->value('count');

        $address_reser_count_details = Address::select(\DB::raw('addr_send_date, COUNT(id) as count'))
            ->where('addr_send_date', '>', $today)
            ->where('deleted_yn', 'n')
            ->groupBy('addr_send_date')
            ->orderBy('addr_send_date', 'desc')
            ->get();

        $deposit_counts = Address::where('deposit_yn', 'n')
            ->where('deleted_yn', 'n')
            ->get();

        $sale_month = Closing::select(\DB::raw('SUM(value) as value'))
            ->where('deleted_yn', 'n')
            ->where('date', '>=', $this_month)
            ->value('value');

        $sale_month_details = Closing::select(\DB::raw('user_id, SUM(value) as value'))
            ->where('date', '>=', $this_month)
            ->where('deleted_yn', 'n')
            ->groupBy('user_id')
            ->get();

        $sale_products = Address::select(\DB::raw('addr_product, SUM(addr_amount) as amount'))
            ->where('addr_gubun', 1)
            ->where('deleted_yn', 'n')
            ->groupBy('addr_product')
            ->orderBy('amount', 'desc')
            ->get();

        $address_daily_counts_temp = Address::select(\DB::raw('addr_send_date, addr_user_id, SUM(addr_amount) as amount'))
            ->where('addr_send_date', '>=', $ago_month)
            ->where('deleted_yn', 'n')
            ->where('addr_gubun', '=', 1)
            ->groupBy(['addr_send_date', 'addr_user_id'])
            ->orderBy('addr_send_date', 'asc')
            ->get();

        $deposit_sum1 = 0;
        $deposit_sum3 = 0;
        $deposit_sum_hn = 0;
        $deposit_sum_total = 0;

        foreach ($deposit_counts as $deposit_count) {
            $deposit_count->value = Closing::where('address_id', $deposit_count->id)->where('deleted_yn', 'n')->value('value');
            if ($deposit_count->addr_user_id == 1) {
                $deposit_sum1 += $deposit_count->value / 10000;
                $deposit_sum_total += $deposit_count->value / 10000;
            }
            if ($deposit_count->addr_user_id == 3) {
                if($deposit_count->addr_reci_name == "해남수산"){
                    $deposit_sum_hn += $deposit_count->value / 10000;
                    $deposit_sum_total += $deposit_count->value / 10000;
                }
                else{
                    $deposit_sum3 += $deposit_count->value / 10000;
                    $deposit_sum_total += $deposit_count->value / 10000;
                }
            }
        }

        foreach($sale_month_details as $sale_month_detail){
            $sale_month_detail->name = User::where('id',$sale_month_detail->user_id)->value('name');
            $sale_month_detail->value = round($sale_month_detail->value / 10000);
        }

        foreach($sale_products as $sale_product){
            $sale_product->addr_product = Product::where('id',$sale_product->addr_product)->value('name');
        }

        $address_daily_counts = array();

        foreach ($address_daily_counts_temp as $address_daily_count_temp) {
            $address_daily_counts[$address_daily_count_temp->addr_send_date][$address_daily_count_temp->addr_user_id] = $address_daily_count_temp->amount;
            if(!array_key_exists(1 ,$address_daily_counts[$address_daily_count_temp->addr_send_date])){
                $address_daily_counts[$address_daily_count_temp->addr_send_date][1] = 0;
            }
            if(!array_key_exists(3 ,$address_daily_counts[$address_daily_count_temp->addr_send_date])){
                $address_daily_counts[$address_daily_count_temp->addr_send_date][3] = 0;
            }
        }

        return view('home',[
            'address_today_count' => $address_today_count,
            'address_today_count1' => $address_today_count1,
            'address_today_count2' => $address_today_count2,
            'address_reser_count' => $address_reser_count,
            'deposit_sum1' => $deposit_sum1,
            'deposit_sum3' => $deposit_sum3,
            'deposit_sum_hn' => $deposit_sum_hn,
            'deposit_sum_total' => $deposit_sum_total,
            'sale_month' => round($sale_month/10000),
            'sale_month_details' => $sale_month_details,
            'address_reser_count_details' => $address_reser_count_details,
            'deposit_counts' => $deposit_counts,
            'sale_products' => $sale_products,
            'address_daily_counts' => $address_daily_counts,
            'today' => $today,
            'address_today' => $address_today,
        ]);
    }

    public function index2()
    {
        $ago_month = date("Y-m-d", strtotime("-1 month", time()));

        $address_counts = Address::select(\DB::raw('addr_send_date, addr_user_id, COUNT(id) as count'))
            ->where('addr_status', '1')
            ->groupBy(['addr_send_date', 'addr_user_id'])
            ->orderBy('addr_send_date', 'desc')
            ->get();

        $deposit_counts = Address::select(\DB::raw('addr_send_date, addr_user_id, COUNT(id) as count'))
            ->where('deposit_yn', 'n')
            ->groupBy(['addr_send_date', 'addr_user_id'])
            ->orderBy('addr_send_date', 'desc')
            ->get();

        $sale_products = Address::select(\DB::raw('addr_product, SUM(addr_amount) as amount'))
            ->where('addr_gubun', '=', 1)
            ->groupBy('addr_product')
            ->orderBy('amount', 'desc')
            ->get();

        $address_daily_counts_temp = Address::select(\DB::raw('addr_send_date, addr_user_id, SUM(addr_amount) as amount'))
            ->where('addr_send_date', '>', $ago_month)
            ->where('addr_gubun', '=', 1)
            ->groupBy(['addr_send_date', 'addr_user_id'])
            ->orderBy('addr_send_date', 'asc')
            ->get();

        foreach($address_counts as $address_count){
            $address_count->addr_user_id = User::where('id',$address_count->addr_user_id)->value('name');
        }
        foreach($deposit_counts as $deposit_count){
            $deposit_count->addr_user_id = User::where('id',$deposit_count->addr_user_id)->value('name');
        }
        foreach($sale_products as $sale_product){
            $sale_product->addr_product = Product::where('id',$sale_product->addr_product)->value('name');
        }

        $address_daily_counts = array();

        foreach ($address_daily_counts_temp as $address_daily_count_temp) {
            $address_daily_counts[$address_daily_count_temp->addr_send_date][$address_daily_count_temp->addr_user_id] = $address_daily_count_temp->amount;
            if(!array_key_exists(1 ,$address_daily_counts[$address_daily_count_temp->addr_send_date])){
                $address_daily_counts[$address_daily_count_temp->addr_send_date][1] = 0;
            }
            if(!array_key_exists(3 ,$address_daily_counts[$address_daily_count_temp->addr_send_date])){
                $address_daily_counts[$address_daily_count_temp->addr_send_date][3] = 0;
            }
        }

        return view('home2',[
            'address_counts' => $address_counts,
            'deposit_counts' => $deposit_counts,
            'sale_products' => $sale_products,
            'address_daily_counts' => $address_daily_counts,
        ]);
    }
}