<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_verified')->nullable()->default('false');
            $table->boolean('is_teacher')->nullable()->default('false');
            $table->rememberToken();
            $table->timestamps(1);
        });

        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('UserID');
            $table->string('Qualification');
            $table->foreign('UserID')
                ->references('id')->on('users')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('formation_date');
        });

        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('UserID');
            $table->integer('class_id');
            $table->foreign('UserID')
                ->references('id')->on('users')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('class_id')
                ->references('id')->on('classes');
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('classID');
            $table->integer('teacherID');
            $table->foreign('classID')
                ->references('id')->on('classes')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('teacherID')
                ->references('id')->on('teachers')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('marks',function (Blueprint $table){
            $table->increments('id');
            $table->integer('case_id');
            $table->integer('student_id');
            $table->dateTime('date');
            $table->char('mark');
            $table->foreign('case_id')
                ->references('id')->on('subjects');
            $table->foreign('student_id')
                ->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('marks');
        Schema::dropIfExists('students');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('users');

        Schema::dropIfExists('personal_access_tokens');
    }
};
