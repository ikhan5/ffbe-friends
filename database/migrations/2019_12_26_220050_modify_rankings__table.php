<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rankings', function(Blueprint $table){
            $table->dropColumn(['unit', 'position', 'role']);
            $table->binary('ballot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rankings', function(Blueprint $table){
            $table->string('unit');
            $table->string('position');
            $table->string('role');
        });
    }
}
