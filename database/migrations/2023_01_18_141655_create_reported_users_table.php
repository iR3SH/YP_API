<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reported_users', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->string('content');
            $table->boolean('isClosed')->default(false);
            $table->integer('closedBy');
            $table->foreign('closedBy')->references('id')->on('users')->onDelete('NO ACTION');
            $table->integer('userWhoReported');
            $table->foreign('userWhoReported')->references('id')->on('users')->onDelete('NO ACTION');
            $table->integer('reportedUser');
            $table->foreign('reportedUser')->references('id')->on('users')->onDelete('NO ACTION');
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
        Schema::dropIfExists('reported_users');
    }
}
