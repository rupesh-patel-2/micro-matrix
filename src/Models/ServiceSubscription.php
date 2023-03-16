<?php

namespace Rupesh\MicroMatrix\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ServiceSubscription extends Model
{
    use HasFactory;

    public static function getSchema(){
        return json_decode('[{"field":"id","type":"bigint","primary":true},{"field":"first_name","type":"string"},{"field":"last_name","type":"string"},{"field":"birthdate","type":"date"},{"field":"created_at","type":"datetime"},{"field":"phone_number","type":"string"}]',true);
    }
}