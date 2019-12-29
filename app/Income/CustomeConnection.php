<?php

namespace App\Income;

use PDO;
use PDOException;

class CustomeConnection
{
    public static function pusher()
    {
        try
        {
            $connect = new PDO("mysql:host=".env('DB_HOST').";dbname=".env('DB_DATABASE'),env('DB_USERNAME'),env('DB_PASSWORD'));
            $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $pusher = $connect->prepare("SELECT * FROM pushers WHERE selected = ?");
            $pusher->execute([1]);

            return $pusher->fetchAll(PDO::FETCH_ASSOC)[0];
        }
        catch(PDOException $e)
        {
            return [
                'driver' => 'pusher',
                'app_key' => env('PUSHER_APP_KEY'),
                'app_secret' => env('PUSHER_APP_SECRET'),
                'app_id' => env('PUSHER_APP_ID'),
                'options' => [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            ];
        }
    }
}