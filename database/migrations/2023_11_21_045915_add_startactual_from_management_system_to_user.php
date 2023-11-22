<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartactualFromManagementSystemToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('management_system_to_user', function (Blueprint $table) {
            $table->integer('start')->default(null)->after('id_system')->nullable();
            $table->integer('actual')->default(null)->after('start')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('management_system_to_user', function (Blueprint $table) {
            //
        });
    }
}
