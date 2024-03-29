<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPrefsActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_prefs_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('idUserPref');
            $table->foreign('idUserPref')->references('id')->on('users_preferences');
            $table->integer('idActivity');
            $table->foreign('idActivity')->references('id')->on('activities');
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
        Schema::dropIfExists('users_prefs_activities');
    }
}
