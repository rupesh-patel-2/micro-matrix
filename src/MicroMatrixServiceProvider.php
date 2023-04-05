<?php
namespace Rupesh\MicroMatrix;
use Rupesh\MicroMatrix\Console\ConfigureMicroMatrix;
use Illuminate\Support\ServiceProvider;

class MicroMatrixServiceProvider extends ServiceProvider {
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ConfigureMicroMatrix::class,
            ]);
        }
        //$this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        // Manager::initiateTenant(1);
    }
    public function register()
    {
        
    }
}
?>