<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unit');
            $table->bigInteger('overall')->default(0)->nullable();
            $table->bigInteger('physTank')->default(0)->nullable();
            $table->bigInteger('magTank')->default(0)->nullable();
            $table->bigInteger('provTank')->default(0)->nullable();
            $table->bigInteger('physDPS')->default(0)->nullable();
            $table->bigInteger('magDPS')->default(0)->nullable();
            $table->bigInteger('hybrids')->default(0)->nullable();
            $table->bigInteger('finishers')->default(0)->nullable();
            $table->bigInteger('healers')->default(0)->nullable();
            $table->bigInteger('buffers')->default(0)->nullable();
            $table->bigInteger('breakers')->default(0)->nullable();
            $table->bigInteger('utility')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
