<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject__teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subjectid')->constrained('subject__class_groups');
            $table->foreignId('tutorid')->constrained('users');
            $table->foreignId('createdById')->constrained('users');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['subjectid', 'tutorid', 'deleted_at'], 'u5');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject__teachers');
    }
}
