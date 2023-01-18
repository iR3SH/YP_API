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
        Schema::create('superlikes', function (Blueprint $table) {
            $table->id();
            $table->integer('idUserWhoLiked');
            $table->foreign('idUserWhoLiked')->references('id')->on('users')->onDelete('NO ACTION');
            $table->integer('idUserWhoBeLiked');
            $table->foreign('idUserWhoBeLiked')->references('id')->on('users')->onDelete('NO ACTION');
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
        Schema::dropIfExists('superlikes');
    }
}
