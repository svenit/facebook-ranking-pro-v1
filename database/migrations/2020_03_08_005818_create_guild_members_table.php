<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuildMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guild_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('guild_id')->index();
            $table->foreign('guild_id')
                ->references('id')
                ->on('guilds')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('member_id')->index();
            $table->foreign('member_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('resources')->default(0);
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
        Schema::dropIfExists('guild_members');
    }
}
