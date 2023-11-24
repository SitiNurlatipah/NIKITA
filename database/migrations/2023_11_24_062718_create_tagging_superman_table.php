<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaggingSupermanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagging_superman', function (Blueprint $table) {
            $table->increments('id_taging_superman');
            $table->string('id_competency_superman');
            $table->string('no_taging');
            $table->year('tahun');
            $table->string('periode');
            $table->string('trainer');
            $table->date('date_verified');
            $table->integer('result_score');
            $table->integer('id_verified_by');
            $table->text('notes_for_result');
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
        Schema::dropIfExists('tagging_superman');
    }
}
