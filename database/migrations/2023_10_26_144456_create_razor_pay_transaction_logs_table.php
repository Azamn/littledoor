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
        Schema::create('razor_pay_transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('amount')->defeult(0);
            $table->string('transaction_number')->unique();
            $table->string('transaction_ref_no')->nullable();
            $table->longText('request_body');
            $table->longText('response_body_1')->nullable();
            $table->longText('response_body_2')->nullable();
            $table->enum('status',['Success','Failure','Processing'])->default('Processing');
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
        Schema::dropIfExists('razor_pay_transaction_logs');
    }
};
