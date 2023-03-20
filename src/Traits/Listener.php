<?php 

namespace Rupesh\MicroMatrix\Traits;

use Illuminate\Support\Facades\Schema;
use Rupesh\MicroMatrix\Traits\Models\Common;
use Rupesh\MicroMatrix\Manager;
/**
 * Use this trait in any model to make it listenable for other micro services
 */
trait Listener
{
    use Common;

    public static function listenTo(){
        /**
         * This function should be defined on the model and needs to specify 
         * the service name, the model and the fields to listen to
         * i.e 
         * return [
         *   'service' => 'contacts',
         *   'model' => 'contacts',
         *   'fields' => ['id','first_name','last_name'] 
         * ];
         * 
         */
        return [];
    }

    public static function refreshSchema(){
        $schema = Manager::getSchema( self::listenTo() );
        if( $schema == false ){
            return false;
        }

        $tableName = self::getTableName();
        $typesToMethods = self::typesToMethods();
        $listenTo = self::listenTo();
        $listenTofields = $listenTo['fields'];

        if( !Schema::hasTable($tableName) ){
            $primary = $schema[0];
            Schema::create($tableName,function($table) use ($tableName,$primary,$typesToMethods){
                $type = $primary['type'];
                $type = $typesToMethods[$type] ? $typesToMethods[$type] : $type;
                $field = $primary['field'];
                $table->$type( $field )->primary();
            });
        }

        Schema::table( $tableName, function($table) use ( $schema, $listenTofields, $tableName ){
            foreach( $schema as $schemaField ){
                if( in_array( $schemaField['field'] , $listenTofields ) ){
                    if( Schema::hasColumn($tableName, $schemaField['field']) == false ){
                        $type = $schemaField['type'];
                        $table->$type( $schemaField['field'] )->nullable()->default( NULL );
                    }
                }
            }
        });

    }

}