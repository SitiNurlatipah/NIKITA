<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLearningMethodFromTaggingSuperman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tagging_superman', function (Blueprint $table) {
            $table->integer('learning_method')->default(null)->after('trainer');
            $table->date('date_plan_implementation')->default(null)->after('trainer');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tagging_superman', function (Blueprint $table) {
            //
        });
    }
}
