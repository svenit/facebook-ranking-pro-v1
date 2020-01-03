<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('class_tag');
            $table->bigInteger('strength')->default(0);
            $table->bigInteger('intelligent')->default(0);
            $table->bigInteger('agility')->default(0);
            $table->bigInteger('lucky')->default(0);
            $table->bigInteger('health_points')->default(0);
            $table->bigInteger('armor_strength')->default(0);
            $table->bigInteger('armor_intelligent')->default(0);
            $table->string('description')->nullable();
            $table->integer('level_required')->default(0);
            $table->integer('vip_required')->default(0);
            $table->string('rgb')->nullable();
            $table->tinyInteger('price_type')->default(0);
            $table->bigInteger('price')->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('pets');
    }
}
