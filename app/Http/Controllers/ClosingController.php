<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Closing;
use App\Address;
use App\User;
use App\Code;
use App\Http\Requests;

class ClosingController extends Controller
{
    //
    protected $closings;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $mode = 1;
        if($request->has('mode')){$mode = $request->mode;}
        $gubun = $request->gubun;
        $user_id = $request->user_id;
        $s_date = $request->s_date;
        $e_date = $request->e_date;
        if($mode == 1) {
            $closings = Closing::select(\DB::raw('date, gubun, SUM(value) as value'))
                ->when($gubun, function ($query, $gubun) {
                    return $query->where('gubun', $gubun);
                })
                ->when($user_id, function ($query, $user_id) {
                    return $query->where('user_id', $user_id);
                })
                ->when($s_date, function ($query, $s_date) {
                    return $query->where('date', '>=', $s_date);
                }, function ($query) {
                    return $query->where('date', '>=', date("Y-m-01"));
                })
                ->when($e_date, function ($query, $e_date) {
                    return $query->where('date', '<=', $e_date);
                })
                ->LeftJoin('addresses', 'closings.address_id', '=', 'addresses.id')
                ->where('closings.deleted_yn', 'n')
                ->groupBy(\DB::raw('date, gubun with rollup'))
                ->get();
        }


        if($mode > 1) {
            $closings = Closing::select(\DB::raw('shop, SUM(value) as value'))
                ->when($gubun, function ($query, $gubun) {
                return $query->where('gubun', $gubun);
            })
                ->when($user_id, function ($query, $user_id) {
                    return $query->where('user_id', $user_id);
                })
                ->when($s_date, function ($query, $s_date) {
                    return $query->where('date', '>=', $s_date);
                })
                ->when($e_date, function ($query, $e_date) {
                    return $query->where('date', '<=', $e_date);
                })
                ->where('deleted_yn', 'n')
                ->groupBy(\DB::raw('shop with rollup'))
                ->get();
        }
        foreach ($closings as $closing){
            $closing->shop = Code::where('code', $closing->shop)->value('content');
            $closing->gubun = Code::where('code', $closing->gubun)->value('content');
            $closing->value = number_format($closing->value);
            $closing->index = $closing->index;
            if($closing->address_id){
                $closing->content = Address::where('id', $closing->address_id)->value('addr_send_name');
            }
        }

        $user_list = User::get();
        $codelist_shop = Code::where('class', 1)
            ->get();
        $codelist_gubun = Code::where('class', 3)
            ->get();

        return view('closing', [
            'closings' => $closings,
            'user_list' => $user_list,
            'user_id' => $user_id,
            'mode' => $mode,
            'gubun' => $gubun,
            's_date' => $s_date,
            'e_date' => $e_date,
            'codelist_shop' => $codelist_shop,
            'codelist_gubun' => $codelist_gubun,
        ]);
    }

    public function write(Request $request)
    {
        $codelist_shop = Code::where('class', 1)
            ->get();
        $codelist_gubun = Code::where('class', 3)
            ->get();

        return view('closing_write', [
            'codelist_shop' => $codelist_shop,
            'codelist_gubun' => $codelist_gubun,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop' => 'required',
            'value' => 'required',
            'gubun' => 'required',
            'content' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/closing/write')
                ->withInput()
                ->withErrors($validator);
        }

        $closings = new Closing;
        $closings->shop = $request->shop;
        $closings->date = $request->date;
        $closings->value= $request->value;
        $closings->gubun = $request->gubun;
        $closings->date = $request->date;
        $closings->content = $request->content;
        $closings->user_id = $request->user()->id;

        $closings->save();

        return redirect('/closing');
        // Create The Task...
    }

    public function destroy(Request $request, Finder $finder)
    {
        $finder->delete();
        return redirect('/finder');
    }
}