<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pusher extends Model
{
    public function config()
    {
        return $this->whereSelected(1)->first();
    }
}
