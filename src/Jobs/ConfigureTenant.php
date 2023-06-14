<?php

namespace Rupesh\MicroMatrix\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Rupesh\MicroMatrix\Models\Tenant;
use Rupesh\MicroMatrix\Manager;

class ConfigureTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        Manager::tenantConfigResult( $this->tenant->configure() );
    }
}