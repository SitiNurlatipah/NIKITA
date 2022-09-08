<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionary', function (Blueprint $table) {
            $table->id('id_dictionary');
            $table->foreignId('Curriculum')->constrained('Curriculum', 'id_curriculum')->onDelete('cascade');
            $table->foreignId('Job_Title')->constrained('Job_Title', 'id_job_title')->onDelete('cascade');
            $table->enum('year01', ['0', '1', '2', '3', '4', '5']);
            $table->enum('year23', ['0', '1', '2', '3', '4', '5']);
            $table->enum('year45', ['0', '1', '2', '3', '4', '5']);
            $table->enum('year67', ['0', '1', '2', '3', '4', '5']);
            $table->enum('year89', ['0', '1', '2', '3', '4', '5']);
            $table->enum('yearYn', ['0', '1', '2', '3', '4', '5']);
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
        Schema::dropIfExists('dictionary');
    }
}
