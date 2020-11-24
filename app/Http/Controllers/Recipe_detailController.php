<?php

namespace App\Http\Controllers;
use Validator;
use App\Recipe_detail;
use App\Recipe;
use App\Product;
use App\Material;
use Illuminate\Http\Request;

class Recipe_detailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($recipe_id)
    {
        $recipe = Recipe::find($recipe_id);
        $recipe->product_name = Product::where('id', $recipe->product_id)->value('name');
        $recipe_detail = Recipe_detail::where('recipe_id', $recipe_id)
            ->where('deleted_yn', 'n')
            ->get();
        $materials = Material::where('deleted_yn', 'n')->get();

        return(view('recipe_details/create', [
            'recipe' => $recipe,
            'recipe_detail' => $recipe_detail,
            'materials' => $materials,
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($recipe_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'weight' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/recipe/'.$recipe_id.'/create')
                ->withInput()
                ->withErrors($validator);
        }

        Recipe_detail::create($request->all());

        return redirect('/recipe');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recipe_detail  $recipe_detail
     * @return \Illuminate\Http\Response
     */
    public function edit($recipe_id, $id)
    {
        $recipe = Recipe::find($recipe_id);
        $recipe->product_name = Product::where('id', $recipe->product_id)->value('name');
        $recipe_detail = Recipe_detail::find($id);
        $materials = Material::where('deleted_yn', 'n')->get();

        return view('recipe_details/edit', [
            'recipe_detail' => $recipe_detail,
            'recipe' => $recipe,
            'materials' => $materials,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipe_detail  $recipe_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $recipe_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'weight' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/recipe/'.$recipe_id.'/edit/'.$id)
                ->withInput()
                ->withErrors($validator);
        }

        $recipe_detail = Recipe_detail::find($id);
        $recipe_detail->material_id = $request->material_id;
        $recipe_detail->weight = $request->weight;
        $recipe_detail->save();

        return redirect('/recipe');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recipe_detail  $recipe_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy($recipe_id, $id)
    {
        $recipe_detail = Recipe_detail::find($id);
        $recipe_detail->deleted_at = date("Y-m-d");
        $recipe_detail->deleted_yn = 'y';
        $recipe_detail->save();

        return redirect('/recipe/');
    }
}
