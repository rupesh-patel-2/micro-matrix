<?php 

namespace Rupesh\MicroMatrix\Traits;

use Rupesh\MicroMatrix\Traits\Models\Common;
use Rupesh\MicroMatrix\Traits\Searchable;

/**
 * Use this trait in any model to make it listenable for other micro services
 */
trait Listenable
{
    use Common,Searchable;

    public static function listenableFields(){
        return self::getDBConnection()->getSchemaBuilder()->getColumnListing(self::getTableName());
    }

    public static function getListenableSchema(){
        $columns = self::listenableFields();
        $table = self::getTableName();
        $primaryKey = self::getPrimaryKeyName();
        $dbConnection = self::getDBConnection();

        $schema = [
            [
                'field' => $primaryKey,
                'type' => $dbConnection->getSchemaBuilder()->getColumnType($table, $primaryKey),
                'primary' => true
            ]
        ];
        foreach($columns as $column){
            if( $column == $primaryKey ){
                continue;
            }
            $schema[] = [
                'field' => $column,
                'type' => $dbConnection->getSchemaBuilder()->getColumnType($table, $column)
            ];
        }
        return $schema;
    }

}
