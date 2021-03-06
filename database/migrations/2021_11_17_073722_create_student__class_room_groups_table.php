<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentClassRoomGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student__class_room_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studentid')->constrained('users');
            $table->foreignId('classroomgroupid')->constrained('class_room_groups');
            $table->foreignId('createdById')->constrained('users');
            $table->softDeletes();
            $table->timestamps();

            // $table->unique(['studentid', 'classroomgroupid']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student__class_room_groups');
    }
}
