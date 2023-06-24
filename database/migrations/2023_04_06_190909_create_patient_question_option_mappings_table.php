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
        Schema::create('patient_question_option_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedInteger('category_question_mapping_id');
            $table->unsignedInteger('option_id');
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
        Schema::dropIfExists('patient_question_option_mappings');
    }
};
