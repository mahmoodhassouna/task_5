<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->string('installmentDueDate',50);
            $table->double('installmentAmount')->length(20);
            $table->double('amountPaid')->length(20)->default(0);
            $table->string('paymentDate',50)->nullable();
            $table->enum('installmentStatus',['غير مسدد','مسدد جزئي','مسدد']);
            $table->foreignId('order_id')->constrained('orders','id')->cascadeOnDelete();
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
        Schema::dropIfExists('installments');
    }
}
