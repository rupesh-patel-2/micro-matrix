<?php

    use Rupesh\MicroMatrix\Http\Controllers\DiscoveryController;
    use Rupesh\MicroMatrix\Http\Controllers\CrudController;
    Route::get('listenables', [DiscoveryController::class,'listenables'])->name('mm.listenables');
    Route::get('listening-to', [DiscoveryController::class,'listeningTo'])->name('mm.listening-to');
    Route::get('test', [DiscoveryController::class,'test']);

    Route::get('mm/crud/{model_name}/search', [CrudController::class , 'search'])->name('mm.model.search');

    Route::post('mm/register-application', [DiscoveryController::class , 'registerApplication'])->name('mm.register-application');
    Route::post('mm/register-tenant', [DiscoveryController::class , 'registerTenant'])->name('mm.register-tenant');
?>