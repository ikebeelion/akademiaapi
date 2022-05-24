<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billingid')->constrained('billings');
            $table->foreignId('mathodid')->constrained('payment_methods');
            $table->foreignId('studentID')->constrained('users');
            $table->enum('approval_status', ['approved', 'not_approved']);
            $table->foreignId('approvedBy')->nullable()->constrained('users');
            $table->string('ref_no');
            $table->foreignId('classgroupid')->constrained('class_groups');
            $table->foreignId('period_id')->nullable()->constrained('term__session__years');
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
        Schema::dropIfExists('payments');
    }
}
