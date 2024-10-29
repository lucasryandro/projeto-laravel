<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treinos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_exercicio');
            $table->foreign('id_exercicio')->references('id')->on('exercicios')->onDelete('cascade');
            $table->unsignedBigInteger('id_rotina');
            $table->foreign('id_rotina')->references('id')->on('rotinas')->onDelete('cascade');
            $table->dateTime('data_treino');
            $table->integer('peso');
            $table->integer('series');
            $table->integer('repeticoes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treinos');
    }
};
