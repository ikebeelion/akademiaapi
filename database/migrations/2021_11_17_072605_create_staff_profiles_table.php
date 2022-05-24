<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staffuseraccountid')->constrained('users');
            $table->string('title')->nullable();
            $table->enum('staff_type', ['teaching', 'non-teaching']);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('othernames')->nullable();
            $table->string('dob')->nullable();
            $table->enum('genderid',['male', 'female']);
            $table->foreignId('nationalityid')->constrained('countries');
            $table->foreignId('stateoforiginid')->nullable()->constrained('states');
            $table->string('local_govt_area')->nullable();
            $table->string('appointment_date')->nullable();
            $table->enum('religion', ['christian', 'islam'])->nullable();
            $table->string('address')->nullable();
            $table->foreignId('countryid')->nullable()->constrained('countries');
            $table->foreignId('stateid')->nullable()->nullable()->constrained('states');
            $table->foreignId('cityid')->nullable()->nullable()->constrained('cities');
            $table->string('contactemail')->nullable();
            $table->string('contacttel')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('rankid')->constrained('ranks');
            $table->foreignId('createdById')->constrained('users');
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
        Schema::dropIfExists('staff_profiles');
    }
}
