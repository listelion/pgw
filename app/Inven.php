<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inven extends Model
{
    protected $table = 'invens';

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
