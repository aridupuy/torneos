<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorTorneoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tor_torneo', function (Blueprint $table) {
            $table->bigInteger("id_torneo");
            $table->bigInteger("id_usser");
            $table->text("tipoTorneo");
            $table->timestamp("fecha");
            $table->text("json_players");
            $table->text("json_matchs");
            $table->text("winner");
            $table->primary("id_torneo");
            $table->autoIncrementingStartingValues(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tor_torneo');
    }
}
