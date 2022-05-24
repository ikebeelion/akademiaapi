<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffectiveDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affective_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studentid')->constrained('users');
            $table->foreignId('academic_periodid')->constrained('term__session__years');
            $table->foreignId('affective_domainid')->constrained('affective_domain_types');
            $table->integer('rating');
            $table->foreignId('createdBy')->constrained('users');
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
        Schema::dropIfExists('affective_domains');
    }
}
