<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosTable extends Migration
{
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('cpf', 14);
            $table->date('data_nascimento');
            $table->string('telefone', 15);
            $table->string('email', 100);
            $table->string('endereco', 255);
            $table->string('cargo', 100);
            $table->date('data_contratacao');
            $table->decimal('salario', 10, 2);
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('access_id');
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->foreign('access_id')->references('id')->on('accesses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}