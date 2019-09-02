<?php

namespace App\facades;

use App\lib\DB as AppDB;

class DB
{
    public static function __callStatic($name, $arguments)
    {
        if (method_exists(AppDB::class, $name)) {
            $db = new AppDB();
            return call_user_func_array([$db, $name], $arguments);
        } else {
            echo "method ta nai";
        }
    }
}