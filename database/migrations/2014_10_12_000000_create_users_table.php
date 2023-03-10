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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_user_type_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_no', 32)->unique();
            $table->string('api_token')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken()->nullable();
            $table->string('password')->nullable();
            $table->unsignedInteger('status')->default(1);
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
        Schema::dropIfExists('users');
    }
};
