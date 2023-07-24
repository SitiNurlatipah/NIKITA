<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdTambahancgFromUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('id_cgtambahan_2',8)->default(null)->after('id_cgtambahan');
            $table->char('id_cgtambahan_3',8)->default(null)->after('id_cgtambahan_2');
            $table->char('id_cgtambahan_4',8)->default(null)->after('id_cgtambahan_3');
            $table->char('id_cgtambahan_5',8)->default(null)->after('id_cgtambahan_4');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
