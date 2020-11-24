<?php

namespace App\Http\Controllers;
use App\Material;
use App\Material_log;
use App\Code;
use Validator;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $materials = Material::where('deleted_yn', 'n')
            ->get();

        foreach ($materials as $material){
            $material_logs = Material_log::where('material_id', $material->id)
                ->where('deleted_yn', 'n')
                ->get();
            foreach($material_logs as $material_log){
                $material_log->per_weight = $material_log->cost / $material_log->weight * 100;
            }
            $material->weight_sum = $material_logs->sum('weight');
            $material->max_cost = round($material_logs->max('per_weight'));
            $material->min_cost = round($material_logs->min('per_weight'));
            $material->avr_cost = round($material_logs->average('per_weight'));
        }

        return view('materials/index', [
            'request' => $request,
            'materials' => $materials,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materials/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/material/create')
                ->withInput()
                ->withErrors($validator);
        }

        $material = new Material;
        $material->name = $request->name;
        $material->origin = $request->origin;
        $material->bigo = $request->bigo;
        $material->save();

        return redirect('/material');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $material = Material::find($id);
        $material_logs = Material_log::where('material_id', $id)
                        ->where('deleted_yn', 'n')
                        ->get();

        foreach ($material_logs as $material_log) {
            $material_log->gubun = Code::where('code', $material_log->gubun)->value('content');
            $material_log->purchase_place = Code::where('code', $material_log->purchase_place)->value('content');
        }
        return view('materials/show', [
            'id' => $id,
            'material' => $material,
            'material_logs' => $material_logs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $material = Material::find($id);

        return view('materials/edit', [
            'id' => $id,
            'material' => $material,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/material/'.$id)
                ->withInput()
                ->withErrors($validator);
        }

        $material = Material::find($id);
        $material->name = $request->name;
        $material->origin = $request->origin;
        $material->bigo = $request->bigo;
        $material->save();

        return redirect('/material/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $material = Material::find($id);
        $material->deleted_yn = "Y";
        $material->deleted_at =  date("Y-m-d");
        $material->save();
        return redirect('/material');
    }
}
