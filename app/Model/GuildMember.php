<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class GuildMember extends Model
{
    protected $guarded = [];

    public function guild()
    {
        return $this->belongsTo('App\Model\Guild','guild_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User','member_id', 'id');
    }
}
