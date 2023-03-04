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
        Schema::create('master_patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('dob');
            $table->string('gender',20);
            $table->unsignedSmallInteger('state_id')->nullable();
            $table->unsignedSmallInteger('city_id')->nullable();
            $table->unsignedSmallInteger('pincode')->nullable();
            $table->string('address_line_1',100)->nullable();
            $table->string('address_line_2',100)->nullable();
            $table->string('contact_1')->nullable();
            $table->string('contact_2')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
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
        Schema::dropIfExists('master_patients');
    }
};
