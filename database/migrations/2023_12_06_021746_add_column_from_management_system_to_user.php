<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFromManagementSystemToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('management_system_to_user', function (Blueprint $table) {
            $table->string('no_sertifikat')->after('keterangan');
            $table->string('no_surat_lisensi')->after('keterangan');
            $table->date('masa_berlaku')->after('keterangan');
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
