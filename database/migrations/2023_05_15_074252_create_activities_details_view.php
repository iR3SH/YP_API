<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesDetailsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("create view activities_details_view as (select `activities`.`id` AS `id`,`activities_type`.`name` AS `TypeName`,`jeux`.`name` AS `JeuxName`,`sorties`.`name` AS `SortieName`,`movies_type`.`name` AS `MovieTypeName`,`sports`.`name` AS `SportName` from (((((`activities` left join `activities_type` on((`activities_type`.`id` = `activities`.`type`))) left join `jeux` on((`jeux`.`id` = `activities`.`idJeux`))) left join `sorties` on((`sorties`.`id` = `activities`.`idSortie`))) left join `sports` on((`sports`.`id` = `activities`.`idSport`))) left join `movies_type` on((`movies_type`.`id` = `activities`.`idMovieType`))))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities_details_view');
    }
}
