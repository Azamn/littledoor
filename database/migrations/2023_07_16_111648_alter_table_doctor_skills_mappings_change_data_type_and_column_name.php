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
        Schema::table('doctor_skills_mappings', function (Blueprint $table) {
            $table->renameColumn('skill_name','skill_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_skills_mappings', function (Blueprint $table) {
            $table->renameColumn('skill_id','skill_name');
        });
    }
};
