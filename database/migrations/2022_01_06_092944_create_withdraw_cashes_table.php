<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_cashes', function (Blueprint $table) {
            $table->id();
            $table->double('withdrawAmount')->length(20);
            $table->string('withdrawDate')->length(40);
            $table->string('reason')->length(150);
            $table->string('attachFile')->length(150);
            $table->foreignId('wallet_id')->constrained('wallets','id')->cascadeOnDelete();
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
        Schema::dropIfExists('withdraw_cashes');
    }
}
