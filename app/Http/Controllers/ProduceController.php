<?php

namespace App\Http\Controllers;
use Validator;
use App\Produce;
use App\Product;
use App\Recipe;
use App\Material;
use App\Material_log;
use App\Recipe_detail;
use Illuminate\Http\Request;

class ProduceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produces = Product::where('recipes.deleted_yn', 'n')
            ->leftJoin('recipes', 'products.id', '=', 'recipes.product_id')
            ->get();

        foreach ($produces as $produce) {
            $produce->details = Recipe_detail::where('deleted_yn', 'n')->where('recipe_id', $produce->id)->get();
            foreach ($produce->details as $detail) {
                $detail->material_name = Material::where('id', $detail->material_id)->value('name');
                $detail->weight_sum = Material_log::where('deleted_yn', 'n')->where('material_id', $detail->material_id)->sum('weight');
                if($detail->weight_sum == 0) {
                    $detail->possible_value = 0;
                }
                else{
                    $detail->possible_value = floor($detail->weight_sum / $detail->weight);
                }
            }
            $produce->possible_value = $produce->details->min('possible_value');
        }

        return view('produces/index', [
            'produces' => $produces,
            'request' => $request,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($produce_id)
    {
        $produce = Recipe::leftJoin('products', 'recipes.product_id', '=', 'products.id')
            ->where('recipes.id', $produce_id)->first();

        return(view('produces/create', [
            'produce' => $produce,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produce  $produce
     * @return \Illuminate\Http\Response
     */
    public function show(Produce $produce)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produce  $produce
     * @return \Illuminate\Http\Response
     */
    public function edit(Produce $produce)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produce  $produce
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produce $produce)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produce  $produce
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produce $produce)
    {
        //
    }
}
