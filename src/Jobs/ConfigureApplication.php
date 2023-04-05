<?php

namespace Rupesh\MicroMatrix\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Rupesh\MicroMatrix\Models\Application;
use Rupesh\MicroMatrix\Manager;

class ConfigureApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function handle()
    {
        Manager::applicationConfigResult($this->application->configure());
    }
}