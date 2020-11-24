<?php

namespace App\Http\Controllers;
use App\Findnum;
use Illuminate\Http\Request;

class FindnumController extends Controller
{
    public function index(Request $request)
    {
        $find_num1 = $request->find_num1;
        $find_num2 = $request->find_num2;
        $find_num3 = $request->find_num3;
        $find_name = $request->find_name;

        $finders = Findnum::where('find_num1', $find_num1)
                ->when($find_num2, function ($query, $find_num2) {
                    return $query->orWhere('find_num2', $find_num2);})
            ->when($find_num3, function ($query, $find_num3) {
                return $query->orWhere('find_num3', $find_num3);})
            ->when($find_name, function ($query, $find_name) {
                return $query->orWhere('find_name', 'like', "%".$find_name."%");})
            ->get();


        $countreq = count($request->all());

        return view('findnum', [
            'finders' => $finders,
            'countreq' => $countreq,
            'ver' => $request->ver,
        ]);
    }
}
