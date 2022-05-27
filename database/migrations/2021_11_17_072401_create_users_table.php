<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roleid')->constrained('roles');
            $table->string('username');
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('stringpassword')->nullable();
            $table->string('email_verified')->nullable();
            $table->foreignId('branchid')->constrained('branches');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['username', 'branchid'], 'u3');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
