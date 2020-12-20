<?php

namespace danolez\lib\DB\DataType;

abstract class DataType
{
    const ARRAY = "ARRAY";
    const BIGINTEGER = "BIGINT";
    const BINARY = "BINARY";
    const BIT  = "BIT";
    const BOOLEAN = "BOOLEAN";
    const BLOB = "BLOB";
    const CHAR = "CHAR";
    const DATE = "DATE";
    const DATETIME = "DATETIME";
    const DECIMAL = "DECIMAL";
    const DOUBLE = "DOUBLE";
    const ENUM = "ENUM";
    const FLOAT = "FLOAT";
    const FILE = "FILE";
    const INTEGER = "INTEGER";
    const LONGBLOB = "LONGBLOB";
    const LONGTEXT = "LONGTEXT";
    const JSON = "JSON";
    const MEDIUMBLOB = "MEDIUMBLOB";
    const MEDIUMINTEGER = "MEDIUMINT";
    const MEDIUMTEXT = "MEDIUMTEXT";
    const POINT = "POINT";
    const SET = "SET";
    const STRING  = "STRING";
    const SMALLINTEGER = "SMALLINT";
    const TINYINTEGER = "TINYINT";
    const TIME = "TIME";
    const TEXT = "TEXT";
    const TIMESTAMP = "TIMESTAMP";
    const TINYBLOB = "TINYBLOB";
    const TINYTEXT = "TINYTEXT";
    const UNSIGNED = "UNSIGNED";
    const VARCHAR = "VARCHAR";
    const VARBINARY = "VARBINARY";
    const YEAR = "YEAR";

    private static function multipleVar($var)
    {
        return "(" . implode(", ", $var) . ")";
    }


    public static function bit(int $size)
    {
        return self::BIT . "(" . ($size) . ")";
    }

    public static function binary(int $size)
    {
        return self::BINARY . "(" . ($size) . ")";
    }

    public static function bigInteger(int $size)
    {
        return self::BIGINTEGER . "(" . ($size) . ")";
    }

    public static function blob(int $size)
    {
        return self::BLOB . "(" . ($size) . ")";
    }

    public static function dateTime($fsp)
    {
        return self::DATETIME . "(" . ($fsp) . ")";
    }

    public static function decimal($size, $d = null)
    {
        if ($d === null)
            return self::DECIMAL . "(" . ($size) . ")";
        else
            return self::DECIMAL . "(" . ($size) . "," . ($d) . ")";
    }

    public static function double($size, $d = null)
    {
        if ($d === null)
            return self::DOUBLE . "(" . ($size) . ")";
        else
            return self::DOUBLE . "(" . ($size) . "," . ($d) . ")";
    }

    public static function enum(...$var)
    {
        return self::ENUM . self::multipleVar($var);
    }

    public static function float($size, $d = null)
    {
        if ($d === null)
            return self::FLOAT . "(" . ($size) . ")";
        else
            return self::FLOAT . "(" . ($size) . "," . ($d) . ")";
    }

    public static function integer(int $size)
    {
        return self::INTEGER . "(" . ($size) . ")";
    }

    public static function mediumInteger(int $size)
    {
        return self::MEDIUMINTEGER . "(" . ($size) . ")";
    }

    public static function set(...$var)
    {
        return self::SET . self::multipleVar($var);
    }


    public static function smallInteger(int $size)
    {
        return self::SMALLINTEGER . "(" . ($size) . ")";
    }

    public static function text(int $size)
    {
        return self::TEXT . "(" . ($size) . ")";
    }

    public static function time($fsp)
    {
        return self::TIME . "(" . ($fsp) . ")";
    }

    public static function timeStamp($fsp)
    {
        return self::TIMESTAMP . "(" . ($fsp) . ")";
    }

    public static function tinyInteger(int $size)
    {
        return self::TINYINTEGER . "(" . ($size) . ")";
    }

    public static function varChar(int $size)
    {
        return self::VARCHAR . "(" . ($size) . ")";
    }

    public static function char(int $size)
    {
        return self::CHAR . "(" . ($size) . ")";
    }

    public static function varBinary(int $size)
    {
        return self::VARBINARY . "(" . ($size) . ")";
    }
}
