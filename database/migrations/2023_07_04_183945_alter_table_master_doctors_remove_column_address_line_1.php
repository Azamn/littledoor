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
        Schema::table('master_doctors', function (Blueprint $table) {
            $table->dropColumn('address_line_1');
            $table->dropColumn('address_line_2');
            $table->dropColumn('state_id');
            $table->dropColumn('pincode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_doctors', function (Blueprint $table) {
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedBigInteger('pincode')->nullable();
        });
    }
};
