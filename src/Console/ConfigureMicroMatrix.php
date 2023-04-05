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

    }
}
