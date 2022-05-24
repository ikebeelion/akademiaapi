<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studentid')->constrained('users');
            $table->foreignId('academic_periodid')->constrained('term__session__years');
            $table->foreignId('subjectid')->constrained('subject__class_groups');
            $table->text('teacher_remark');
            $table->foreignId('createdBy')->constrained('users');
            $table->string('ca');
            $table->string('exam');
            $table->string('score');
            $table->string('avg');
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
        Schema::dropIfExists('performance_comments');
    }
}
