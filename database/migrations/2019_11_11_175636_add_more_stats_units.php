<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreStatsUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('hp')->default('100');
            $table->string('mp')->default('100');
            $table->string('pevade')->default('0');

            $table->binary('physkillers')->nullable();
            $table->binary('magkillers')->nullable();
            $table->binary('status')->nullable();
            $table->binary('elemental')->nullable();
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
    }
}
