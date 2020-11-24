<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
class SenderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request){
        $user_id = $request->user_id;
        $gubun = $request->gubun;
        $status = $request->status;
        $s_date = $request->s_date;
        $e_date = $request->e_date;
        $name = $request->name;
        $senders = Address::when($status, function ($query, $status) {
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

        return view('sender.index', [
            'senders' => $senders,
            'name' => $request->user()->name,
            'status' => $request->status,
            'user_id' => $request->user_id,
            'gubun' => $request->gubun,
            's_date' => $request->s_date,
            'e_date' => $request->e_date,
        ]);
    }

    public function store(){

    }
}
