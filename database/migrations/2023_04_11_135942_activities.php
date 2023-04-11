<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Activities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->string('name')->nullable();
            $table->integer('idJeux')->nullable();
            $table->integer('idMovieType')->nullable();
            $table->integer('idSortie')->nullable();
            $table->integer('idSport')->nullable();
            $table->foreign('type')->references('id')->on('activities_type');
            $table->foreign('idJeux')->references('id')->on('jeux');
            $table->foreign('idMovieType')->references('id')->on('movie_type');
            $table->foreign('idSortie')->references('id')->on('sorties');
            $table->foreign('idSport')->references('id')->on('sports');
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
        Schema::dropIfExists('activities');
    }
}
