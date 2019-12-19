<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pushers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('app_id');
            $table->string('app_key');
            $table->string('app_secret');
            $table->string('cluster')->default('ap1');
            $table->tinyInteger('selected')->default(0);
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
        Schema::dropIfExists('pushers');
    }
}
