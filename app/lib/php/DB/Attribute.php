<?php

namespace danolez\lib\DB\Attribute;

abstract class Attribute
{
    const CHARACTER = "CHARACTER";
    const SET = "SET";
    const UTF8 = "utf8";
    const UTF8_BIN = "utf8_bin";
    const COLLATE = "COLLATE";
    const USING = "USING";
    const
    DEFAULT = "DEFAULT";
    const CURRENT_TIMESTAMP = "CURRENT_TIMESTAMP";
    const KEY = "KEY";
    const PRIMARY_KEY = "PRIMARY KEY";
    const AUTO_INCREMENT = "AUTO_INCREMENT";
    const NULL = "NULL";
    const NOT_NULL = "NOT NULL";
    const FOREIGN_KEY = "FOREIGN KEY";
    const INDEX = "INDEX";
    const TABLES = "TABLES";
    const TABLE = "TABLE";
    const DATABASE = "DATABASE";
    const UNIQUE = "UNIQUE";
    const CONSTRAINT = "CONSTRAINT";
    const CHECK = "CHECK";
    const REFERENCES = "REFERENCES";
    const DIFFERENTIAL = "DIFFERENTIAL";
    const RESPONSE = "response";
    const TOTAL = "TOTAL";

    public static function check(string $var)
    {
        return self::CHECK . " (" . ($var) . ")";
    }

    public static function primaryKey(string $var)
    {
        return self::PRIMARY_KEY . " (" . ($var) . ")";
    }

    public static function foreignKey(string $var)
    {
        return self::FOREIGN_KEY . " (" . ($var) . ")";
    }

    public static function set(string $var)
    {
        return $var;
    }
}
