<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('character_id');
            $table->string('image')->nullable();
            $table->foreign('character_id')
                ->references('id')
                ->on('characters')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('power_value')->default(0);
            $table->tinyInteger('power_type')->default(0);
            $table->string('type');
            $table->string('description');
            $table->tinyInteger('required_level')->default(0);
            $table->tinyInteger('passive')->default(0);
            $table->integer('energy')->default(0);
            $table->integer('success_rate')->default(0);
            $table->string('rgb')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('skills');
    }
}
