<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('configs', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->tinyInteger('maintaince');
        //     $table->string('access_token');
        //     $table->string('group_id');
        //     $table->date('started_day');
        //     $table->integer('per_post');
        //     $table->integer('per_comment');
        //     $table->integer('per_commented');
        //     $table->integer('per_react');
        //     $table->integer('per_reacted');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
