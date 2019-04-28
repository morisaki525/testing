<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('rec_id')->unique();
            $table->string('met_id', 100);
            $table->unsignedInteger('user_id');
            $table->string('rec_unit');
            $table->string('rec_cash');
            $table->string('rec_dute_date');
            $table->string('rec_pay_date');
            $table->string('rec_create_date');
            $table->string('rec_paid');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')
                ->on('users')->onDelete('cascade');

            $table->foreign('met_id')->references('met_id')
                ->on('meter')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('record');
    }
}
