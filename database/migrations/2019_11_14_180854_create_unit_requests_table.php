<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('unit_name');
            $table->string('weapon_ele');
            $table->string('details')->nullable();
            $table->binary('physkillers')->nullable();
            $table->binary('killers')->nullable();
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
        Schema::dropIfExists('unit_requests');
    }
}
