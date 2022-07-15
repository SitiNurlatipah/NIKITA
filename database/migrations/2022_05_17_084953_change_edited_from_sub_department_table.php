<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEditedFromSubDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_department', function (Blueprint $table) {
            $table->renameColumn('updated_ad','updated_at')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_department', function (Blueprint $table) {
            $table->renameColumn('updated_at','updated_ad')->change();
        });
    }
}
