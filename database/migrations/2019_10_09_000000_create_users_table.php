<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('user_id')->unique()->nullable();
            $table->string('provider_id')->unique()->nullable();
            $table->unsignedBigInteger('character_id')->default(0);
            $table->foreign('character_id')
                ->references('id')
                ->on('characters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('posts')->default(0);
            $table->string('reactions')->default(0);
            $table->string('comments')->default(0);
            $table->bigInteger('coins')->default(0);
            $table->bigInteger('income_coins')->default(0);
            $table->bigInteger('gold')->default(0);
            $table->string('exp')->default(0);
            $table->bigInteger('strength')->default(0);
            $table->bigInteger('intelligent')->default(0);
            $table->bigInteger('agility')->default(0);
            $table->bigInteger('lucky')->default(0);
            $table->bigInteger('health_points')->default(150);
            $table->bigInteger('armor_strength')->default(0);
            $table->bigInteger('armor_intelligent')->default(0);
            $table->bigInteger('full_power')->default(0);
            $table->integer('pvp_points')->default(0);
            $table->tinyInteger('isAdmin')->default(0);
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->integer('energy')->default(0);
            $table->integer('pvp_times')->default(0);
            $table->integer('stranger_chat_times')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
