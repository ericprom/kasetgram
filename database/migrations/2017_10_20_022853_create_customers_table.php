<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('phone');
            $table->string('tax_id');
            $table->string('nationality')->nullable();
            $table->string('street')->nullable();
            $table->string('district')->nullable();
            $table->string('amphoe')->nullable();
            $table->string('province')->nullable();
            $table->string('zipcode')->nullable();
            $table->integer('branch_id')->unsigned()->index();
            $table->integer('active')->default(1);
            $table->timestamps();
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
        Schema::dropIfExists('customers');
    }
}
