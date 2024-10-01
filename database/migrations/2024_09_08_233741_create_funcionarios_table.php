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
            $table->string('telefone', 15);
            $table->string('email', 100);
            $table->string('cargo', 100);
            $table->date('data_contratacao');
            $table->decimal('salario', 10, 2);
            $table->unsignedBigInteger('access_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->foreign('access_id')->references('id')->on('accesses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}