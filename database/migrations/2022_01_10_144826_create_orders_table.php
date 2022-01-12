<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('projectName',40);
            $table->string('beneficiaryName',40);
            $table->string('orderDate',40);
            $table->string('idNumber',9)->unique();
            $table->string('phone',10);
            $table->string('repaymentFinancingAmountMonths',30);
            $table->double('projectAmount')->length(20);
            $table->double('expectedProfit')->length(20);
            $table->enum('projectType',['زراعي','تجاري','صناعي']);
            $table->enum('orderCase',['قيد الدراسة','مرفوض','مقبول']);
            //$table->boolean('paymentCase')->default(0)->length(1);
            $table->string('CloseReason',150)->nullable();
            $table->foreignId('wallet_id')->nullable()->constrained('wallets','id')->nullOnDelete();
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
        Schema::dropIfExists('orders');
    }
}
