<?php

namespace Rupesh\MicroMatrix;

use Rupesh\MicroMatrix\Utilities\SingletonAbstract;
use Rupesh\MicroMatrix\Models\Application;
use Rupesh\MicroMatrix\Models\Tenant;
use Rupesh\MicroMatrix\ManagerTraits\Common;
use Rupesh\MicroMatrix\ManagerTraits\Services;
use Rupesh\MicroMatrix\ManagerTraits\Tenancy;

class Manager extends SingletonAbstract {
    use Services,Common,Tenancy;
    protected $tenant = false;
    protected $application = false;

    public static function initiateTenant( $tenantId ){
        $initialized = false;
        $tenant = Tenant::find( $tenantId );
        if( $tenant ){
            $application = $tenant->application();
            if( $application ){
                self::setTenant( $tenant );
                self::setApplication( $application );
                /** Make db connection here to correct tenant database */
                // DB::connect('mysql');
                $initialized = true;
            }
        }
        return $initialized;
    }
}