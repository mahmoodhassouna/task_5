<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawAddCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_add_cashes', function (Blueprint $table) {
            $table->id();
            $table->double('amount')->length(20);
            $table->string('date')->length(40);
            $table->string('reason')->length(150);
            $table->string('attachFile')->length(150);
            $table->foreignId('wallet_id')->constrained('wallets','id')->cascadeOnDelete();
            $table->enum('type',['اضافة','سحب']);
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
        Schema::dropIfExists('withdraw_add_cashes');
    }
}
