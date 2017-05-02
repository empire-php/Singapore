<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRosterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roster_settings', function (Blueprint $table) {
            $table->increments('id');
			$table->string('team_name');
			$table->string('team_leader');
			$table->string('embalmers');
			$table->string('others');
			$table->int('add_to_roster');
			$table->int('is_deleted');
			$table->timestamps('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roster_settings');
    }
}
