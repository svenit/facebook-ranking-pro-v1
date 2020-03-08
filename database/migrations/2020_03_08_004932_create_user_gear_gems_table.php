<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGearGemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gear_gems', function (Blueprint $table) {
            $table->unsignedBigInteger('user_gear_id')->index();
            $table->foreign('user_gear_id')
                ->references('id')
                ->on('user_gears')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_gem_id')->index();
            $table->foreign('user_gem_id')
                ->references('id')
                ->on('user_gems')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->primary(['user_gear_id', 'user_gem_id']);
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
        Schema::dropIfExists('user_gear_gems');
    }
}
