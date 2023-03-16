<?php 

namespace Rupesh\MicroMatrix\Traits\Models;

trait Common {
    public static function getTableName(){
        return (new self())->getTable();
    }

    public static function getDBConnection(){
        return (new self())->getConnection();
    }

    public static function getPrimaryKeyName(){
        return (new self())->getKeyName();
    }

    public static function typesToMethods(){
        return [
            'bigint' => 'biginteger'
        ];
    }
}