<?php

namespace App\Income;

use PDO;
use Illuminate\Support\Facades\Schema;

class CustomeConnection
{
    public static function pusher()
    {
        if(Schema::hasTable('pushers'))
        {
            $connect = new PDO("pgsql:host=".env('DB_HOST').";dbname=".env('DB_DATABASE'),env('DB_USERNAME'),env('DB_PASSWORD'));
            $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $pusher = $connect->prepare("SELECT * FROM pushers WHERE selected = ?");
            $pusher->execute([1]);

            return $pusher->fetchAll(PDO::FETCH_ASSOC)[0];
        }
    }
}