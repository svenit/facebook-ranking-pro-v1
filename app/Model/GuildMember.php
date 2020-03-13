<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GuildMember extends Model
{
    protected $fillable = [
        'guild_id', 'member_id', 'resources'
    ];
}
