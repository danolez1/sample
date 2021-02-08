<?php

namespace danolez\lib\DB;

abstract class Location
{

    const TABLE = "TABLE";
    const DISK = "DISK";
    const DATABASE = "DATABASE";
    const COLUMN = "COLUMN";    
    const INTO = "INTO";

    public static function disk(string $path)
    {
        return self::DISK . " = '" . ($path) . ".bak'";
    }
}
