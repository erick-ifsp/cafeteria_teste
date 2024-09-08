<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessesTable extends Migration
{
    public function up()
    {
        Schema::create('accesses', function (Blueprint $table) {
            $table->id(); // bigint UNSIGNED AUTO_INCREMENT
            $table->string('nome', 100);
            $table->timestamps(); // created_at, updated_at
            $table->engine = 'InnoDB';
        });
    }

    public function down()
    {
        Schema::dropIfExists('accesses');
    }
}