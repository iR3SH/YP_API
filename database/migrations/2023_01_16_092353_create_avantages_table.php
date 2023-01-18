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
            $table->boolean('canUseExtraFilter')->default(false);
            $table->boolean('canSeeWhoLiked')->default(false);
            $table->boolean('canReceiveDailyExtraLike')->default(false);
            $table->boolean('canGoBack')->default(false);
            $table->boolean('isPremiumProfil')->default(false);
            $table->decimal('price');
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
