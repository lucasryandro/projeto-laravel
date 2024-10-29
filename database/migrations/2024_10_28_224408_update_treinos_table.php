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
        Schema::table('treinos', function (Blueprint $table) {
            $table->unsignedBigInteger('progresso_peso_id');
            $table->foreign('progresso_peso_id')->references('id')->on('progressao_peso')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('treinos', function (Blueprint $table) {
            $table->dropColumn('progresso_peso_id');

        });
    }
};
