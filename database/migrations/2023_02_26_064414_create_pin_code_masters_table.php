<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pin_code_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pincode');
            $table->unsignedInteger('country_code');
            $table->unsignedInteger('state_id');
            $table->unsignedInteger('city_id');
            $table->string('area',50)->nullable();
            $table->decimal('latitude',10,7)->nullable();
            $table->decimal('longitude',10,7)->nullable();
            $table->string('geospatial_accuracy',50)->nullable();
            $table->unsignedTinyInteger('sequence')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pin_code_masters');
    }
};
