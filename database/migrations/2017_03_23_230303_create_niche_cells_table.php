<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNicheCellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('niche_cells', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('niche_section_id');
            $table->string('row_text');
            $table->string('column_text');
            $table->string('status');
            $table->integer('row_order');
            $table->integer('column_order');
            $table->tinyInteger('side');
            $table->text('description');
            $table->decimal('selling_price');
            $table->decimal('maintenance_fee');
            $table->string('type');
            $table->integer('staff_name');
            $table->string('customer_name');
            $table->text('hold_description');
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
        Schema::drop('niche_cells');
    }
}
