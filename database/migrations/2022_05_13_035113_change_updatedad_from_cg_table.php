<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUpdatedadFromCgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cg', function (Blueprint $table) {
            $table->renameColumn('updated_ad','updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cg', function (Blueprint $table) {
            $table->renameColumn('updated_at','updated_ad');
        });
    }
}
