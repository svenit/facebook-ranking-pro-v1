<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('avatar');
            $table->bigInteger('strength')->default(0);
            $table->bigInteger('health_points')->default(0);
            $table->bigInteger('intelligent')->default(0);
            $table->bigInteger('agility')->default(0);
            $table->bigInteger('lucky')->default(0);
            $table->bigInteger('armor_strength')->default(0);
            $table->bigInteger('armor_intelligent')->default(0);
            $table->bigInteger('default_energy')->default(0);
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
        Schema::dropIfExists('characters');
    }
}
