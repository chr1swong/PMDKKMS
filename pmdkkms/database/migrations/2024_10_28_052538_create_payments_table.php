<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedInteger('account_id');
            $table->string('membership_id');
            $table->decimal('amount', 10, 2);
            $table->string('payment_status')->default('Pending'); // Pending, Completed, Failed
            $table->string('toyyibpay_billcode')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('account_id')->on('account')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
