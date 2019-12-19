<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpinWheelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spin_wheels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('probability')->default(0);
            $table->string('type');
            $table->string('value');
            $table->string('result_text');
            $table->text('query');
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
        Schema::dropIfExists('spin_wheels');
    }
}
