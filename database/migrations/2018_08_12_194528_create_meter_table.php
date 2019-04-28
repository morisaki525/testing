<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meters', function (Blueprint $table) {
            $table->string('met_id', 100)->unique();
            //add--
            $table->string('met_name');
            $table->text('met_type');
            $table->unsignedInteger('user_id');
            //--
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')
                    ->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meter');
    }
}
