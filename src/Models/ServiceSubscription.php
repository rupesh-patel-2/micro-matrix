<?php

namespace Rupesh\MicroMatrix\Models;

use Illuminate\Database\Eloquent\Model;
use Rupesh\MicroMatrix\Manager;
use Illuminate\Support\Facades\Http;

class ServiceSubscription extends Model
{
    
    public function tenant() {
        return $this->hasOne( Tenant::class );
    }

    public function getSchema( $listenTo ) {
        $schema = false;
        $endPoints = self::getEndpoints();
        $url = $this->url.$endPoints['listenables'];
        $response = Http::get( $url );
        if ( $response->successful() ) {
            $body = json_decode( $response->body(), true);
            
            $model = $listenTo['model'];
            if( isset($body['models'][$model]) ) {
                $schema = $body['models'][$model];
            }
        }
        return $schema;
    }

    public static function getEndpoints(){
        return [
            'listenables' => '/listenables'
        ];
    }
}