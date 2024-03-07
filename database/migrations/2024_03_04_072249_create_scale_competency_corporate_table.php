<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScaleCompetencyCorporateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scale_competency_corporate', function (Blueprint $table) {
            $table->increments('id_scale_corporate');
            $table->integer('golongan');
            $table->string('curriculum_corporate');
            $table->text('scale_1');
            $table->text('scale_2');
            $table->text('scale_3');
            $table->text('scale_4');
            $table->text('scale_5');
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
        Schema::dropIfExists('scale_competency_corporate');
    }
}
