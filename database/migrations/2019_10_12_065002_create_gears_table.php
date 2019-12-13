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
            $table->bigInteger('strength')->default(0);
            $table->bigInteger('intelligent')->default(0);
            $table->bigInteger('agility')->default(0);
            $table->bigInteger('lucky')->default(0);
            $table->bigInteger('health_points')->default(0);
            $table->bigInteger('armor_strength')->default(0);
            $table->bigInteger('armor_intelligent')->default(0);
            $table->string('description');
            $table->integer('level_required');
            $table->string('rgb')->nullable();
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
