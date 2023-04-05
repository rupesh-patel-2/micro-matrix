<?php

namespace Rupesh\MicroMatrix\Models;

use Illuminate\Database\Eloquent\Model;
use Rupesh\MicroMatrix\Manager;
use Rupesh\MicroMatrix\Jobs\ConfigureApplication;

class Application extends Model
{
    public static function registerApplication( $application ) {
        $validationResult = self::validateApplication($application);
        if($validationResult['success'] == false){
            return $validationResult;
        }
        $appObj = new self();
        $appObj->name = $application['name'];
        $appObj->uuid = $application['uuid'];
        $appObj->description = isset($application['description']) ? $application['description'] : null;
        $appObj->url = isset($application['url']) ? $application['url'] : null;
        $appObj->save();
        ConfigureApplication::dispatch($appObj);
        return [ "success" => true , 'application' => $appObj ];
    }

    public static function validateApplication( $application ){
        $result = true;
        $message = "Application is Valid";
        if( !isset( $application['uuid'] ) ){
            $result = false;
            $message = "Missing Application uuid";
        }

        if( !isset( $application['name'] ) ){
            $result = false;
            $message = "Missing Application name";
        }
        return [
            'success' => $result,
            'message' => $message
        ];
    }

    public function configure(){
        $this->status = "active";
        $this->save();
    }
}