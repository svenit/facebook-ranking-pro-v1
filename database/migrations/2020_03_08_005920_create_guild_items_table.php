<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuildItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guild_items', function (Blueprint $table) {
            $table->unsignedBigInteger('guild_id')->index();
            $table->foreign('guild_id')
                ->references('id')
                ->on('guilds')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('item_id')->index();
            $table->foreign('item_id')
                ->references('id')
                ->on('guild_shops')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->dateTime('expire_at');
            $table->primary(['guild_id', 'item_id']);
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
        Schema::dropIfExists('guild_items');
    }
}
