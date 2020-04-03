<?php

namespace App\Services;

class HttpCURL
{
    public static function get($url)
    {
        $ch = curl_init();
        CURL_SETOPT_ARRAY($ch,[
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14',
            CURLOPT_ENCODING => '',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => TRUE,
        ]);
        $excec = curl_exec($ch);
        curl_close($ch);
        return $excec;
    }
}