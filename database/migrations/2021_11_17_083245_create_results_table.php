<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restult_typeid')->constrained('result_types');
            $table->foreignId('studentid')->constrained('users');
            $table->foreignId('academic_periodid')->constrained('term__session__years');
            $table->foreignId('subjectid')->constrained('subject__class_groups');
            $table->foreignId('classroomid')->constrained('class_room_groups');
            $table->string('score_obtained');
            $table->foreignId('createdById')->constrained('users');
            $table->softDeletes();
            $table->timestamps();

            // unique
            $table->unique(['restult_typeid',
            'studentid',
            'academic_periodid',
            'subjectid', 'classroomid'] , 'u7');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
