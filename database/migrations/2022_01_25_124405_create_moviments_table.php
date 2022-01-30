<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moviments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->double('value');
            $table->date('date');

            $table->unsignedBigInteger('types_id');
            $table->foreign('types_id')
                ->references('id')
                ->on('types');

            $table->unsignedBigInteger('categories_id')->nullable();
            $table->foreign('categories_id')
                ->references('id')
                ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moviments');
    }
}
