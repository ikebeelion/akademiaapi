<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studentuseraccountid')->constrained('users');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('othernames')->nullable();
            $table->string('dob');
            $table->enum('genderid',['male', 'female']);
            $table->foreignId('nationalityid')->constrained('countries');
            $table->foreignId('stateoforiginid')->constrained('states');
            $table->string('local_govt_area');
            $table->string('enrollmentdate')->nullable();
            $table->enum('religion', ['christian', 'islam']);
            $table->string('address');
            $table->foreignId('countryid')->constrained('countries');
            $table->foreignId('stateid')->constrained('states');
            $table->foreignId('cityid')->constrained('cities');
            $table->string('contactemail')->nullable();
            $table->string('contacttel');
            $table->enum('payment_status', ['paid', 'not-paid', 'incomplete'])->default('not-paid');
            $table->enum('promotion_status', ['new', 'old'])->default('new');
            $table->string('photo')->nullable();
            $table->foreignId('yearid')->constrained('class_groups');
            $table->foreignId('createdById')->constrained('users');
            $table->foreignId('classid')->nullable()->constrained('class_room_groups');
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
        Schema::dropIfExists('student_profiles');
    }
}
