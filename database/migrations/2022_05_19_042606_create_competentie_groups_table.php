<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetentieGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competencie_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('id_skill_category');
            $table->string('name');
            $table->foreign('id_skill_category')->references('id_skill_category')->on('skill_category')->cascadeOnDelete();
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
        Schema::dropIfExists('competentice_groups');
    }
}
