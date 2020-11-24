<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Closing extends Model
{
    //
    protected $fillable = ['name'];

    public function address()
    {
        return $this->belongsTo(User::class);
    }
}
