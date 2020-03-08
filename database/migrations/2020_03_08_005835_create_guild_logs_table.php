<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuildLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guild_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('guild_id')->index();
            $table->foreign('guild_id')
                ->references('id')
                ->on('guilds')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('log')->nullable();
            $table->string('type');
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
        Schema::dropIfExists('guild_logs');
    }
}
