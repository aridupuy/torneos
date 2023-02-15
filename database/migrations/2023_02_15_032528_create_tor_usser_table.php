<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorUsserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tor_usser', function (Blueprint $table) {
            $table->bigInteger("id_usser");
            $table->text("usser");
            $table->bigInteger("password");
            $table->primary("id_usser");
            $table->autoIncrementingStartingValues(0);
        });
        $data=array(
            array(
                "id_usser"=>"1",
                "usser"=>"ariel",
                "password"=>"1234"
            )
        );
        foreach ($data as $datum){
            $usser = new \App\Models\Usser();
            $usser->set_password($datum["password"]);
            $usser->set_usser($datum["usser"]);
            $usser->set();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tor_usser');
    }
}
