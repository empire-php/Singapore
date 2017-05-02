<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNicheOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('niche_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_nr');
            $table->integer('created_by');
            $table->integer('funeral_arrangement_id');
            $table->integer('niche_block_id');
            $table->integer('niche_suite_id');
            $table->integer('niche_section_id');
            $table->integer('niche_cell_id');
            $table->string('other_text', 30);
            $table->decimal('other_price');
            $table->decimal('gst');
            $table->decimal('total');
            $table->string('remark');
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
        //
        Schema::drop('niche_orders');
    }
}
