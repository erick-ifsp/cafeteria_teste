<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id');
            $table->string('nome', 255);
            $table->decimal('preco', 10, 2);
            $table->string('descricao', 500);
            $table->string('produto_arquivo', 255)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}