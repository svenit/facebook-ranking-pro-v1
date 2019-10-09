<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public function scopeAvaiable($query)
    {
        $hiddenId = [0];
        return $query->whereNotIn('id',$hiddenId)->get();
    }
}
