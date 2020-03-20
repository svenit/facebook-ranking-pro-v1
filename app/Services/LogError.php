<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LogError
{
    public static function log($e)
    {
        $error = "Error on line {$e->getLine()} in {$e->getFile()} : {$e->getMessage()}";
        $fileName = date('d-m-Y');
        Storage::append("errors/{$fileName}.log", $error);
    }
}