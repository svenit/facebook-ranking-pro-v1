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
            $table->integer('strength')->default(0);
            $table->integer('intelligent')->default(0);
            $table->integer('agility')->default(0);
            $table->integer('lucky')->default(0);
            $table->integer('health_points')->default(150);
            $table->bigInteger('full_power')->default(0);
            $table->tinyInteger('isVip')->default(0);
            $table->tinyInteger('isAdmin')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
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
