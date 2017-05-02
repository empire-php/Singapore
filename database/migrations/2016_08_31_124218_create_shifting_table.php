<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_contact_name');
            $table->string('first_contact_number');
            $table->string('second_contact_name');
            $table->string('second_contact_number');
            $table->string('deceased_name');
            $table->string('hospital');
            $table->string('send_parlour');
            $table->string('send_outside');
            $table->string('status')->default('pending');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('send_outside');
            $table->text('remarks');
            $table->integer('creator_id');
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
        Schema::drop('shifting');
    }
}
