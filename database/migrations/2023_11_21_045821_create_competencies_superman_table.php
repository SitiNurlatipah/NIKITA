<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetenciesSupermanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competencies_superman', function (Blueprint $table) {
            $table->increments('id_competencies_superman');
            $table->integer('id_cstu');
            $table->integer('id_user');
            $table->integer('start');
            $table->integer('actual');
            $table->integer('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competencies_superman');
    }
}
