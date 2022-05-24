<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('useraccountid')->constrained('users');
            $table->enum('title', ['mr', 'miss', 'mrs', 'dr', 'engr', 'prof']);
            $table->string('occupation')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('othernames')->nullable();
            $table->string('dob')->nullable();
            $table->enum('genderid',['male', 'female'])->nullable();
            $table->foreignId('nationalityid')->nullable()->constrained('countries');
            $table->foreignId('stateoforiginid')->nullable()->constrained('states');
            $table->string('local_govt_area')->nullable();
            $table->enum('religion', ['christian', 'islam'])->nullable();
            $table->string('address')->nullable();
            $table->foreignId('countryid')->nullable()->constrained('countries');
            $table->foreignId('stateid')->nullable()->constrained('states');
            $table->foreignId('cityid')->nullable()->constrained('cities');
            $table->string('contactemail')->nullable();
            $table->string('contacttel')->nullable();
            $table->string('photo')->nullable();;
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
        Schema::dropIfExists('parent_profiles');
    }
}
