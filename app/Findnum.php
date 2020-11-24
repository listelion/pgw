<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Findnum extends Model
{
    protected $table = 'finders';

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
