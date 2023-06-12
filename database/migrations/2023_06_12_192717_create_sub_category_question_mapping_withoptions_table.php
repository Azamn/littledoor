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
        Schema::create('sub_category_question_mapping_with_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sub_category_question_mapping_id');
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
        Schema::dropIfExists('sub_category_question_mapping_with_options');
    }
};
