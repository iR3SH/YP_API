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
            $table->string('Reason');
            $table->integer('idUser');
            $table->integer('idAdmin');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('NO ACTION');
            $table->foreign('idAdmin')->references('id')->on('users')->onDelete('NO ACTION');
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
