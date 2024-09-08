<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartaosTable extends Migration
{
    public function up()
    {
        Schema::create('cartaos', function (Blueprint $table) {
            $table->id(); // bigint UNSIGNED AUTO_INCREMENT
            $table->unsignedBigInteger('user_id');
            $table->string('numero', 256);
            $table->string('nome', 191);
            $table->string('data', 5);
            $table->string('cvv', 10);
            $table->timestamps(); // created_at, updated_at
            $table->engine = 'InnoDB';

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cartaos');
    }
}
