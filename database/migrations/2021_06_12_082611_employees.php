<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Employees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',20);
            $table->string('last_name',20);
            $table->string('address',100);
            $table->boolean('gender');
            $table->string('email',70)->unique();
            $table->string('phone',11)->unique();
            $table->unsignedBigInteger('regency_id');
            $table->foreign('regency_id')->references('id')->on('regency');
            $table->unsignedBigInteger('salary_id');
            $table->foreign('salary_id')->references('id')->on('salary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('employees');
    }
}
