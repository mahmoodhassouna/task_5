<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->string('idNumber',9);
            $table->date('installmentDueDate',50);
            $table->double('amountPaid')->length(20)->default(0);
            $table->date('paymentDate',50)->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('iteration')->default(0);
            $table->string('reason',150)->nullable();
            $table->string('fileName',100)->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
}
