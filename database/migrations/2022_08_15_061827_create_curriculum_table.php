<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculum', function (Blueprint $table) {
            $table->id('txtId');
            $table->string('txtNoCompetency')->unique();
            $table->foreignId('txtSkillCategory')->constrained('skill_category', 'txtId')->onDelete('cascade');
            $table->string('txtCompetencyName')->unique();
            $table->enum('txtLevel', ['Basic', 'Intermediate', 'Advance']);
            $table->foreignId('txtCompetencyGroup')->constrained('competency_group', 'txtIdCompetencyGroup')->onDelete('cascade');
            $table->string('txtJobTitle')->nullable();
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
        Schema::dropIfExists('curriculum');
    }
}
