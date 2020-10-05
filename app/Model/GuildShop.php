<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuildShop extends Model
{
    use SoftDeletes;

    protected $guarded = [];
}
