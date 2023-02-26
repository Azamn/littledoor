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
        Schema::create('doctor_qualification_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('qualification_id');
            $table->string('certificate_no')->nullable();
            $table->unsignedInteger('no_of_years_experience')->nullable();
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
        Schema::dropIfExists('doctor_qualification_mappings');
    }
};
