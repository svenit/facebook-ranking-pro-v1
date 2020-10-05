<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGiftCode extends Model
{
    use SoftDeletes;

    protected $guarded = [];

}
