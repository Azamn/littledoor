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
        Schema::table('razor_pay_transaction_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('tax_amount')->after('amount')->defeult(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('razor_pay_transaction_logs', function (Blueprint $table) {
            $table->dropColumn('total_amount');
        });
    }
};
