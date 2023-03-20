<?php 

namespace Rupesh\MicroMatrix\ManagerTraits;

use Rupesh\MicroMatrix\Models\ServiceSubscription;

trait Services {

    public static function getServiceSubscription ( $service ) {
        $tenantId = self::inst()->tenant ? self::inst()->tenant->id : false;
        return ServiceSubscription::where('name','=',$service)->where('tenant_id','=',$tenantId)->first();
    }

    public static function getSchema ( $listenTo ) {
        $schema = false;
        $serviceSubscription = self::getServiceSubscription( $listenTo['service'] );
        return $schema;
    }
}