<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperlikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_likes', function (Blueprint $table) {
            $table->id();
            $table->integer('idUserWhoLiked');
            $table->foreign('idUserWhoLiked')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('idUserWhoBeLiked');
            $table->foreign('idUserWhoBeLiked')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('super_likes');
    }
}
