<?php 

namespace Rupesh\MicroMatrix\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Rupesh\MicroMatrix\Utilities\Models;

class DiscoveryController extends BaseController{

    public function listenables() {
        $models = Models::getAllModels();
        $listenables = ['models' => []];
        foreach($models as $model){
            if(method_exists($model,'getListenableSchema')){
                $listenables['models'][] = [
                    $model::getTableName() => $model::getListenableSchema()
                ];
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
    
}