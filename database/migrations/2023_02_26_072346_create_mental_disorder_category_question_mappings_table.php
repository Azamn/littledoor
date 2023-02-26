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
        Schema::create('mental_disorder_category_question_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('mental_disorder_category_id');
            $table->string('question');
            $table->unsignedTinyInteger('status')->default(1)->nullable();
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
        Schema::dropIfExists('mental_disorder_category_question_mappings');
    }
};
