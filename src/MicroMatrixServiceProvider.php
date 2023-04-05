<?php
namespace Rupesh\MicroMatrix;

use Illuminate\Support\ServiceProvider;

class MicroMatrixServiceProvider extends ServiceProvider {
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        // $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        // Manager::initiateTenant(1);
    }
    public function register()
    {
        
    }
}
?>