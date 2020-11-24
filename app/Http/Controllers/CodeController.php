<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Code;

class CodeController extends Controller
{
    protected $codes;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $class = $request->class;
        $sub_codes = Code::where('class', 0)->get();


        $codes = Code::when($class, function ($query, $class) {return $query->where('class', $class);})
            ->paginate(10);

        return view('code', [
            'codes' => $codes,
            'sub_codes' => $sub_codes,
            'name' => $request->user()->name,
            'request' => $request,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:5',
            'content' => 'required|max:45',
        ]);

        if ($validator->fails()) {
            return redirect('/code')
                ->withInput()
                ->withErrors($validator);
        }

        $codes = new Code();
        $codes->code = $request->code;
        $codes->content = $request->content;
        $codes->class = $request->class;
        $codes->save();

        return redirect('/code');
        // Create The Task...
    }

    public function write(Request $request)
    {
        $codes = Code::get();
        $id = 0;
        if($request->class == 0) {
            $default_code_temp = Code::where('class', 0)->orderBy('code', 'desc')->first();
            $default_code = str_pad(($default_code_temp->code + 1), 2, '0', STR_PAD_LEFT);
        }
        if($request->class > 0) {
            $default_code_temp = Code::where('class', $request->class.'%')->orderBy('code', 'desc')->first();
            if(isset($default_code_temp) > 0){
                $default_code = str_pad(($default_code_temp->code + 1), 5, '0', STR_PAD_LEFT);
            }
            else{
                $default_code = Code::where('id', $request->class)->value('code') . "001";
            }
        }
        $sub_codes = Code::where('class', 0)->get();

        return view('/code_write', [
            'codes' => $codes,
            'sub_codes' => $sub_codes,
            'sub_codes' => $sub_codes,
            'default_code' => $default_code,
            'id' => $id,
            'request' => $request,
        ]);
    }

    public function edit($id)
    {
        $code = Code::find($id);
        $sub_codes = Code::where('class', 0)->get();
        return view('/code_write', [
            'code' => $code,
            'sub_codes' => $sub_codes,
            'id' => $id,
        ]);
    }

    public function write_store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:5',
            'content' => 'required|max:45',
        ]);

        if ($validator->fails()) {
            return redirect('/code')
                ->withInput()
                ->withErrors($validator);
        }

        $codes = Code::find($id);
        $codes->code = $request->code;
        $codes->content = $request->content;
        $codes->class = $request->class;
        $codes->save();

        return redirect('/code');
    }

}
