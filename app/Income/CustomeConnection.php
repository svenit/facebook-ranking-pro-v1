<?php

namespace App\Income;

use PDO;

class CustomeConnection
{
    public static function pusher()
    {
        $connect = new PDO("pgsql:host=".env('DB_HOST').";dbname=".env('DB_DATABASE'),env('DB_USERNAME'),env('DB_PASSWORD'));
        $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $connect->exec('SET NAMES UTF8MB4');

        $pusher = $connect->prepare("SELECT * FROM pushers WHERE selected = ?");
        $pusher->execute([1]);

        return $pusher->fetchAll(PDO::FETCH_ASSOC)[0];
    }
}