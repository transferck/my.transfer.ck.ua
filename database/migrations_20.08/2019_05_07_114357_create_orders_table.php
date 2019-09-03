<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('fio')->nullable();
            $table->string('phone')->nullable();
			$table->string('type')->nullable();
			$table->string('airport_ukraine')->nullable();
			$table->string('airport_world')->nullable();
			$table->string('terminal')->nullable();
			$table->dateTime('datetime')->nullable();
			$table->time('registration')->nullable();
			$table->string('flight')->nullable();
			$table->string('address')->nullable();
			$table->integer('tickets')->nullable();
			$table->string('transfer')->nullable();
			$table->string('status_order')->nullable();
			$table->string('status_pay')->nullable();
			$table->string('option_nameplate')->nullable();
			$table->string('option_babyseat')->nullable();
			$table->text('info')->nullable();
			$table->string('status')->nullable();
			$table->unsignedBigInteger('user_id')->unsigned()->index();
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

