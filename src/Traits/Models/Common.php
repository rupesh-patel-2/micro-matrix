<?php 

namespace Rupesh\MicroMatrix\Traits\Models;

trait Common {
    public static function getTableName(){
        return with(new static)->getTable();
    }

    public static function getDBConnection(){
        return with(new static)->getConnection();
    }

    public static function getPrimaryKeyName(){
        return with(new static)->getKeyName();
    }

    public static function typesToMethods(){
        return [
            'bigint' => 'biginteger'
        ];
    }

}