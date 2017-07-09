<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('turn');
            $table->integer('route_id');
            $table->integer('agency_id');
            $table->date('date');
            $table->string('hour')->nullable();
            $table->integer('type_id')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->integer('chauffeur_id')->nullable();
            $table->string('courier')->nullable();
            $table->integer('passengers')->nullable();
            $table->decimal('paying')->nullable();
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
        Schema::dropIfExists('services');
    }
}
