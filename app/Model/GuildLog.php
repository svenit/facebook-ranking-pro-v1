<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuildLog extends Model
{
    use SoftDeletes;
    protected $guarded = [];
}
