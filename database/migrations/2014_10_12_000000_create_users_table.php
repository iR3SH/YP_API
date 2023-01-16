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
            $table->string('Name');
            $table->string('Lastname');
            $table->string('Email')->unique();
            $table->timestamp('Email_verified_at')->nullable();
            $table->string('Password');
            $table->string('Gender');
            $table->string('PhoneNumber');
            $table->string('City');
            $table->string('Activities');
            $table->string('MusicStyles');
            $table->string('RedFlags');
            $table->string('Languages');
            $table->string('MoviePref');
            $table->string('GenderPref');
            $table->boolean('Verified');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
