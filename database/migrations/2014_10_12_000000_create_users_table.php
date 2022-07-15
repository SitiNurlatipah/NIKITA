<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 25);
            $table->string('nama_pengguna', 100);
            $table->string('peran_pengguna', 10);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('tgl_masuk');
            $table->string('id_job_title');
            $table->string('id_divisi');
            $table->string('id_cg');
            $table->string('id_department');
            $table->string('id_sub_department');
            $table->string('id_level');
            $table->boolean('status');
            $table->string('gambar');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
