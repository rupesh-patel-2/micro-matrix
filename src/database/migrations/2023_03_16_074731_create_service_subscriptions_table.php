<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('uuid');
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->text('data')->nullable();
            $table->bigInteger('tenant_id')->unsigned()->index()->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_subscriptions');
    }
}
