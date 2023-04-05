<?php

namespace Rupesh\MicroMatrix\Models;

use Illuminate\Database\Eloquent\Model;
use Rupesh\MicroMatrix\Manager;
use Rupesh\MicroMatrix\Jobs\ConfigureTenant;
class Tenant extends Model
{
    public function application() {
        return $this->hasOne( Application::class );
    }

    public static function registerTenant( $tenant ) {
        $result = self::validateTenant( $tenant );
        if( !$result['success'] ) {
            return $result;
        }
        $tenantObj = Tenant::where('uuid','=',$tenant['uuid'])->first();
        if( !$tenantObj ) {
            $tenantObj = new Tenant();
        }
        $tenantObj->name = $tenant['name'];
        $tenantObj->uuid = $tenant['uuid'];
        $tenantObj->application_id = $tenant['application_id'];

        $tenantObj->save();
        $tenantObj->database_name = env('SERVICE_NAME','service').'_'.$tenant['application_id'].'_'.$tenantObj->id;
        $tenantObj->save();
        ConfigureTenant::dispatch( $tenantObj );
        return [ "success" => true , 'tenant' => $tenantObj ];
    }

    public static function validateTenant( $tenant ) {
        $result = true;
        $message = "Tenant is valid";

        if( !isset($tenant['uuid']) ){
            $result = false;
            $message = "Missing uuid"; 
        }

        if( !isset($tenant['application_uuid']) ){
            $result = false;
            $message = "Missing application_uuid"; 
        } else {
            $appObj = Application::where('uuid','=',$tenant['application_uuid'])->first();
            if( !$appObj ){
                $result = false;
                $message = "Could not find application with ".$tenant['application_uuid'];
            } else {
                $tenant['application_id'] = $appObj->id;
            }
        }

        if( !isset($tenant['name']) ){
            $result = false;
            $message = "Missing name"; 
        }

        return [
            "success" => $result,
            "message" => $message,
            "tenant" => $tenant
        ];
    }

    public function getKeyPhrase(){
        return md5($this->id.$this->uuid.$this->database_name);
    }

    public function getCurrentStatus(){
        return [
            'configured' => true,
            'migrated' => true,
            'last_migration_date' => date('Y-m-d')
        ];
    }

    public function configure() {
        $this->createTenantDbAndUser();
        $this->configureTenantConnection();
        $this->migrate();
        return $this->getCurrentStatus();
    }


    public function createTenantDbAndUser(){
        $host = 'localhost';
        $dbName = $this->database_name;
        \DB::statement('CREATE DATABASE IF NOT EXISTS '.$dbName);
        \DB::statement("CREATE USER IF NOT EXISTS '".$dbName."'@'".$host."' IDENTIFIED BY '".$this->getKeyPhrase()."'");
        \DB::statement("GRANT ALL PRIVILEGES ON ".$dbName.".* TO '".$dbName."'@'".$host."' WITH GRANT OPTION;");
    }

    public function configureTenantConnection(){
        $detaultConnection = config('database.default');
        $tenantConnection = env('TENANT_CONNECTION','tenant');
        $connectionSettings = config('database.connections.'.$detaultConnection);
        $connectionSettings['database'] = $this->database_name;
        $connectionSettings['username'] = $this->database_name;
        $connectionSettings['password'] = $this->getKeyPhrase();
        config(['database.connections.'.$tenantConnection => $connectionSettings]);
    }

    public function migrate(){
        $tenantConnection = env('TENANT_CONNECTION','tenant');
        $res = \Artisan::call('migrate --database='.$tenantConnection);
    }

}