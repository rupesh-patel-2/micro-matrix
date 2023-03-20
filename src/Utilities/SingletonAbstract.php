<?php 

namespace Rupesh\MicroMatrix\Utilities;

abstract class SingletonAbstract {
    static $inst = false;
    public static function inst( $params = [] ) {
        $className = get_called_class();
		if(self::$inst == false){
			self::$inst = new $className( $params );
		}
		return self::$inst;
	}

    public static function __callStatic( $func, $args ){
       
        $res = self::anylyzeFunc( $func );
        $methodFound = false; 
        if( $res['type'] != false ){
            $inst = self::inst();
            switch ($res['type']) {
                case 'set':
                        $prop = $res['data']['prop'];
                        $value = $args[0];
                        $inst->$prop = $value;
                        $methodFound = true;
                    break;
                case 'get':
                        $prop = $res['data']['prop'];
                        $methodFound = true;
                        return $inst->$prop;
                    break;
                default:
                    break;
            }
        }
        if( !$methodFound ){
            $className = get_called_class();
            trigger_error('Call to undefined method '.$className.'::'.$func.'()', E_USER_ERROR);
        }
    }

    public static function anylyzeFunc( $func ) {
        $response = [
            'type' => false,
            'data' => [],
        ];

        $arr = preg_split('/(?=[A-Z])/',$func);
        if(count($arr) > 1){
            $firstPart = $arr[0];
            if( in_array( $firstPart, ['get','set']) ){
                $arr[1] = strtolower($arr[1]);
                array_shift($arr);
                $prop = implode('',$arr);
                if( property_exists( self::inst(), $prop) ){
                    $response['type'] = $firstPart;
                    $response['data'] = [
                        'prop' => $prop
                    ];
                }
            }
        }
        return $response;
    }
}