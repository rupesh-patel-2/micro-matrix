<?php

    use Rupesh\MicroMatrix\Http\Controllers\DiscoveryController;
    Route::get('listenables', [DiscoveryController::class,'listenables']);
    Route::get('listening-to', [DiscoveryController::class,'listeningTo']);
    Route::get('test', [DiscoveryController::class,'test']);
?>