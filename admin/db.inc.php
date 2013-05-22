<?php

require_once "db.config.php"

class Database
{
    public static function Query($sql, $data = array())
    {
        $connection = new PDO("mysql:host=".DBConfig::$HOST.";dbname=".DBConfig::$DATABASE, DBConfig::$USERNAME, DBConfig::$PASSWORD);

        $res = $connection->prepare($sql);
        $res->execute($data);

        if(!$res)
            throw new Exception($connection->errorInfo());

        return $res;
    }

}
