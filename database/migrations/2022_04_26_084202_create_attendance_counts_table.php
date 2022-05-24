<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studentid')->constrained('users');
            $table->foreignId('classid')->constrained('class_room_groups');
            $table->foreignId('subjectid')->constrained('subject__class_groups');
            $table->foreignId('periodid')->constrained('term__session__years');
            $table->string('count_attendance');
            $table->foreignId('no_of_classes')->constrained('users');
            $table->foreignId('tutor')->constrained('users');
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
        Schema::dropIfExists('attendance_counts');
    }
}
