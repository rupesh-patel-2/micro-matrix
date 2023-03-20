<?php

namespace Rupesh\MicroMatrix\Models;

use Illuminate\Database\Eloquent\Model;
use Rupesh\MicroMatrix\Manager;

class Tenant extends Model
{
    public function application() {
        return $this->hasOne( Application::class );
    }
}