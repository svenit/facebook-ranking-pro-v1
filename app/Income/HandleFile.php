<?php

namespace App\Income;

trait HandleFile
{
    public static function upload($path, $file)
    {
        try
        {
            $name = md5(uniqid().time()).'.'.$file->getClientOriginalExtension();
            if($file->move($path, $name))
            {
                return "{$path}/{$name}";
            }
        }
        catch(Exception $e)
        {
            return null;
        }
    }
}