<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned()->nullable()->index();
            $table->integer('make_id')->unsigned()->index();
            $table->string('model');
            $table->string('year');
            $table->string('license');
            $table->string('province');
            $table->string('capacity')->nullable();
            $table->string('chassi_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('engine_size')->nullable();
            $table->string('weight')->nullable();
            $table->integer('customer_id')->unsigned()->index();
            $table->integer('branch_id')->unsigned()->index();
            $table->integer('active')->default(1);
            $table->timestamps();
            $table->foreign('type_id')->references('id')->on('types');
            $table->foreign('make_id')->references('id')->on('makes');
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('cars');
    }
}
