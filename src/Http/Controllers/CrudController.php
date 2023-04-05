<?php 

namespace Rupesh\MicroMatrix\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Rupesh\MicroMatrix\Utilities\Models;
use Rupesh\MicroMatrix\Manager;

class CrudController extends BaseController {

    public function search( $modelName )
	{
		$modelName = Manager::camelize( $modelName );
		$modelClass = "App\\Models\\" . $modelName;
		if (!class_exists( $modelClass )) {
			$response = ['error' => 'Model not defined ' . $modelName];
		} else {
			$response = $modelClass::searchRecords( request()->all() );
		}
		return $response;
	}
    
}