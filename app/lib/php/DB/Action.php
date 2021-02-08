<?php

namespace danolez\lib\DB;

abstract class Action
{
    const ADD = "ADD";
    const CREATE = "CREATE";
    const DROP = "DROP";
    const DELETE = "DELETE";
    const ALTER = "ALTER";
    const GETDATE = "GETDATE()";
    const MODIFY = "MODIFY";
    const SELECT = "SELECT";
    const VIEW = "VIEW";
    const REPLACE = "REPLACE";
    const BACKUP = "BACKUP";
    const INSERT = "INSERT";
    const UPDATE = "UPDATE";
    const SHOW = "SHOW";
    const COUNT = "COUNT";
    const BIND_RESULT = 'bind_result';

    public function count(string $id)
    {
        return self::COUNT . "(" . $id . ")";
    }
}
