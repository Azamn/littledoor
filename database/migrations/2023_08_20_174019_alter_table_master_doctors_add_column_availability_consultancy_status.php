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
            $table->tinyInteger('consultancy_status')->after('total_no_of_years_experience')->default(0);
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
            $table->dropColumn('consultancy_status');
        });
    }
};
