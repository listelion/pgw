<?php

namespace App\Http\Controllers;
use Validator;
use App\Recipe;
use App\Recipe_detail;
use App\Product;
use App\Material;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $recipes = Recipe::where('deleted_yn', 'n')->get();
        foreach ($recipes as $recipe){
            $recipe->product_name = Product::where('id', $recipe->product_id)->value('name');
            $recipe->details = Recipe_detail::where('deleted_yn', 'n')->where('recipe_id', $recipe->id)->get();
            foreach ($recipe->details as $detail){
                $detail->material_name = Material::where('id', $detail->material_id)->value('name');
            }
        }


        return(view('recipes/index',[
            'recipes' => $recipes,
            'request' => $request,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product_lists = Product::where('deleted_yn', 'n')->get();

        return(view('recipes/create', [
            'request' => $request,
            'product_lists' => $product_lists,
        ]));
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
            'output' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/recipe/create')
                ->withInput()
                ->withErrors($validator);
        }

        Recipe::create($request->all());

        return redirect('/recipe');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        $product_lists = Product::where('deleted_yn', 'n')->get();

        return(view('recipes/edit', [
            'product_lists' => $product_lists,
            'recipe' => $recipe,
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        $validator = Validator::make($request->all(), [
            'output' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/recipe/'.$recipe->id.'/edit')
                ->withInput()
                ->withErrors($validator);
        }

        $recipe->product_id = $request->product_id;
        $recipe->output = $request->output;
        $recipe->save();

        return redirect('/recipe');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recipe  $recipe
    * @return \Illuminate\Http\Response
        */
    public function destroy(Recipe $recipe)
    {
        $recipe->deleted_yn = "Y";
        $recipe->deleted_at =  date("Y-m-d");
        $recipe->save();
        return redirect('/recipe');
    }
}
