<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('walletName',40)->unique();
            $table->string('attachWallet',150)->nullable();
            $table->double('baseAmount')->length(20);
            $table->double('totalAmount')->length(20);
            $table->boolean('status')->default(1)->length(1);
            $table->double('highestAmountCanWithdrawn')->length(20);
            $table->foreignId('banks_id')->nullable()->constrained('banks','id')->nullOnDelete();
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
        Schema::dropIfExists('wallets');
    }
}
