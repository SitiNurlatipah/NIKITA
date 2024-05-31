<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUseridCurriculumidFromTagingReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taging_reason', function (Blueprint $table) {
            $table->integer('id_user')->after('id_white_tag');
            $table->integer('id_curriculum')->after('id_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taging_reason', function (Blueprint $table) {
            //
        });
    }
}
