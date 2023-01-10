<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('moviments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->integer('value');
            $table->date('date');
            $table->timestamps();

            $table->foreignId('types_id')->constrained();
            $table->foreignId('categories_id')->nullable()->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moviments');
    }
}
