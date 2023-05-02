<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banned_users', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp');
            $table->string('reason');
            $table->boolean('isLifeTime')->default(false);
            $table->integer('idUser');
            $table->integer('idAdmin');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('idAdmin')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('banned_users');
    }
}
