<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrainerFromCurriculumChampion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculum_champion', function (Blueprint $table) {
            $table->string('trainer')->after('target');
            $table->string('level')->after('target');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculum_champion', function (Blueprint $table) {
            //
        });
    }
}
