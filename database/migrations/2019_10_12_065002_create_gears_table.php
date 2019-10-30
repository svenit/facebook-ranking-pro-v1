<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gears', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image');
            $table->unsignedBigInteger('character_id');
            $table->foreign('character_id')
                ->references('id')
                ->on('characters');
            $table->unsignedBigInteger('cate_gear_id');
            $table->foreign('cate_gear_id')
                ->references('id')
                ->on('cate_gears');
            $table->string('type');
            $table->integer('value');
            $table->string('description');
            $table->integer('level_required');
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
        Schema::dropIfExists('gears');
    }
}
