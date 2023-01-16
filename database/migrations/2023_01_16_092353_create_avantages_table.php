<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvantagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avantages', function (Blueprint $table) {
            $table->id();
            $table->boolean('canUseExtraFilter');
            $table->boolean('canSeeWhoLiked');
            $table->boolean('canReceiveDailyExtraLike');
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
        Schema::dropIfExists('avantages');
    }
}
