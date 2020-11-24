<?php

namespace App;
use Validator;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $guarded = [];

    public function scopeLists($query){
        return $query->leftJoin('products', 'recipes.product_id', '=', 'products.id')
            ->where('recipes.deleted_yn','n')->get();
    }
}
