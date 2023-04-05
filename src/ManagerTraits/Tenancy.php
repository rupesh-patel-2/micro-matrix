<?php 
namespace Rupesh\MicroMatrix\ManagerTraits;
use Rupesh\MicroMatrix\Models\Application;
use Rupesh\MicroMatrix\Models\Tenant;

trait Tenancy {
    
    public static function registerApplication( $application = [] ){
        return Application::registerApplication( $application );
    }

    public static function registerTenant( $tenant = []){
        return Tenant::registerTenant( $tenant );
    }

    public static function applicationConfigResult( $result ) {
        // update central system about application status 
    }

    public static function tenantConfigResult( $result ) {
        // update central system about tenant status 
    }
}