<?php

namespace Rupesh\MicroMatrix\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConfigureMicroMatrix extends Command
{
    protected $signature = 'micro-matrix:config';
    protected $description = 'Configures MicroMatrix package';

    public function handle(){
        $this->info('Configuring MicroMatrix...');

        $this->info('Running Migrations for base tables ...');

        $migrationsPath = __DIR__ . '/../database/migrations';
        $destMigrationDir = base_path('database').'/micro-matrix';

        if( !is_dir($destMigrationDir) ){
            mkdir( $destMigrationDir );
        }

        $files = scandir($migrationsPath);
        foreach($files as $file){
            $sourceFile = $migrationsPath.'/'.$file;
            if ( is_file($sourceFile) ){
                $destFile = $destMigrationDir.'/'.$file;
                if( !is_file($destFile) ) {
                    copy( $sourceFile , $destFile);
                }
            }
        }
        
        $res = \Artisan::call('migrate --path="database/micro-matrix"');
        $this->info( ( string ) \Artisan::output() );
    }
}
