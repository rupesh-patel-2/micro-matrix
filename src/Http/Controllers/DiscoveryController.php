<?php 

namespace Rupesh\MicroMatrix\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Rupesh\MicroMatrix\Utilities\Models;
use Illuminate\Http\Request;
use Rupesh\MicroMatrix\Manager;

class DiscoveryController extends BaseController{

    public function listenables() {
        $models = Models::getAllModels();
        $listenables = ['models' => []];
        foreach($models as $model){
            if(method_exists($model,'getListenableSchema')){
                $listenables['models'][$model::getTableName()] = $model::getListenableSchema();
            }
        }
        return $listenables;
    }

    public function listeningTo() {
        $models = Models::getAllModels();
        $listeningTo = ['models' => []];
        foreach($models as $model){
            if(method_exists($model,'listenTo')){
                $listeningTo['models'][] = [
                    $model::getTableName() => $model::listenTo()
                ];
            }
        }
        return $listeningTo;
    }

    public function test(){
        \App\Models\Contact::refreshSchema();
    }

    public function registerApplication(Request $request){
        return Manager::registerApplication($request);
    }

    public function registerTenant(Request $request){
        return Manager::registerTenant($request);
    }
    
}