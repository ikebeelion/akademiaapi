<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classRoomGroupid')->nullable()->constrained('class_room_groups');
            $table->foreignId('classGroupId')->nullable()->constrained('class_groups');
            $table->enum('timetabletype', ['class_timetable', 'exam_timetable', 'continous_accessment']);
            $table->foreignId('subjectid')->constrained('subject__class_groups');
            $table->foreignId('academic_periodid')->constrained('term__session__years');
            $table->string('from');
            $table->string('to');
            $table->enum('day', ['monday', 'tuesday', 'wednesday', 'thursday','friday','saturday','sunday']);
            $table->string('date');
            $table->foreignId('branchid')->constrained('branches');
            $table->foreignId('createdById')->constrained('users');
            $table->enum('status', ['approved', 'not_approved']);
            $table->softDeletes();
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
        Schema::dropIfExists('timetables');
    }
}
