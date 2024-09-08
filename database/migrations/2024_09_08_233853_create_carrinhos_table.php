<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrinhosTable extends Migration
{
    public function up()
    {
        Schema::create('carrinhos', function (Blueprint $table) {
            $table->id(); // bigint UNSIGNED AUTO_INCREMENT
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('produto_id');
            $table->string('tipo', 256);
            $table->integer('quantidade')->default(1);
            $table->timestamps(); // created_at, updated_at
            $table->engine = 'InnoDB';

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carrinhos');
    }
}
