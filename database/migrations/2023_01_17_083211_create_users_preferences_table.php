<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('musicStyles')->nullable();
            $table->string('redFlags')->nullable();
            $table->string('languages')->nullable();
            $table->string('genderPref')->nullable();
            $table->integer('distancePref')->default(0);
            $table->integer('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('users_preferences');
    }
}
