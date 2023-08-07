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
        Schema::table('master_patients', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->after('status')->nullable();
            $table->unsignedInteger('sub_category_id')->after('category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_patients', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('sub_category_id');
        });
    }
};
