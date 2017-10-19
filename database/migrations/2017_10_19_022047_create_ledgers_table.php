<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->increments('id');
            $table->date('withdraw_date')->nullable();
            $table->string('withdrawer')->nullable();
            $table->integer('expense_id')->unsigned()->index();
            $table->string('detail')->nullable();
            $table->string('amount')->nullable();
            $table->integer('payment_id')->unsigned()->index();
            $table->integer('branch_id')->unsigned()->index();
            $table->integer('active')->default(1);
            $table->timestamps();
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('branch_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledgers');
    }
}
