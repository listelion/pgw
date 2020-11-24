<?php

namespace App\Http\Controllers;
use Validator;
use App\Material;
use App\Material_log;
use App\Code;
use Illuminate\Http\Request;

class Material_logController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($material_id)
    {
        $material = Material::find($material_id);
        $gubun_codes = Code::where('class', 24)->get();
        $purchase_codes = Code::where('class', 29)->get();

        return view('material_logs/create',[
            'material_id' => $material_id,
            'material' => $material,
            'gubun_codes' => $gubun_codes,
            'purchase_codes' => $purchase_codes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $material_id)
    {
        $validator = Validator::make($request->all(), [
            'weight' => 'required',
            'cost' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/material/'.$material_id.'/create')
                ->withInput()
                ->withErrors($validator);
        }

        Material_log::create($request->all());

        return redirect('/material/'.$material_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material_log  $material_log
     * @return \Illuminate\Http\Response
     */
    public function edit($material_id, $id)
    {
        $material = Material::find($material_id);
        $material_log = Material_log::find($id);
        $gubun_codes = Code::where('class', 24)->get();
        $purchase_codes = Code::where('class', 29)->get();

        return view('material_logs/edit', [
            'material_log' => $material_log,
            'material' => $material,
            'gubun_codes' => $gubun_codes,
            'purchase_codes' => $purchase_codes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material_log  $material_log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $material_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'weight' => 'required',
            'cost' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/material/'.$material_id.'/edit/'.$id)
                ->withInput()
                ->withErrors($validator);
        }

        $material_log = Material_log::find($id);
        $material_log->gubun = $request->gubun;
        $material_log->weight = $request->weight;
        $material_log->cost = $request->cost;
        $material_log->purchase_place = $request->purchase_place;
        $material_log->date = $request->date;
        $material_log->save();

        return redirect('/material/'.$material_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material_log  $material_log
     * @return \Illuminate\Http\Response
     */
    public function destroy($material_id, $id)
    {
        $material_log = Material_log::find($id);
        $material_log->deleted_yn = "Y";
        $material_log->deleted_at =  date("Y-m-d");
        $material_log->save();

        return redirect('/material/'.$material_id);
    }
}
