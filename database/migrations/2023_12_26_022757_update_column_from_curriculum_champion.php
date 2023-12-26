<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnFromCurriculumChampion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculum_champion', function (Blueprint $table) {
            $table->dropColumn('id_skill_category');
            $table->dropColumn('curriculum_group');
            $table->integer('id_group_champion')->after('curriculum_champion');
            $table->integer('id_sub_group_champion')->after('id_group_champion');
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
