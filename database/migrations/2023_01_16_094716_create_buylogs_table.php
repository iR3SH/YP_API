<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuylogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buylogs', function (Blueprint $table) {
            $table->id();
            $table->integer('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('NO ACTION');
            $table->integer('idSubscription');
            $table->foreign('idSubscription')->references('id')->on('subscriptions')->onDelete('NO ACTION');
            $table->decimal('cost');
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
        Schema::dropIfExists('buylogs');
    }
}
