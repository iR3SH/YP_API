<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('CASCADE');
            $table->timestamp('timestamp');
            $table->dateTime('nextCost')->nullable();
            $table->integer('idAvantage');
            $table->foreign('idAvantage')->references('id')->on('avantages')->onDelete('CASCADE');
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
        Schema::dropIfExists('subscriptions');
    }
}
