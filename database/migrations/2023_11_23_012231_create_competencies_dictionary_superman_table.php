<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetenciesDictionarySupermanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competencies_dictionary_superman', function (Blueprint $table) {
            $table->increments('id_dictionary_superman');
            $table->integer('id_curriculum_superman');
            $table->integer('id_user');
            $table->integer('target');
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
        Schema::dropIfExists('competencies_dictionary_superman');
    }
}
