<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMasaberlakuFromManagementSystemToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('management_system_to_user', function (Blueprint $table) {
            $table->dropColumn('masa_berlaku');
            $table->date('masa_berlaku_sertif')->after('no_surat_lisensi');
            $table->date('masa_berlaku_lisensi')->after('masa_berlaku_sertif');
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
