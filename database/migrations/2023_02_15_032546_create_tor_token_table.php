<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tor_token', function (Blueprint $table) {
            $table->bigInteger("id_token");
            $table->text("token");
            $table->bigInteger("id_usser");
            $table->timestamp("fechagen");
            $table->primary("id_token");
            $table->autoIncrementingStartingValues(0);
        });
        
            $data=array(
                array(
                    'id_token'=> '1',
                    'token' => 'c68df523fef6e357da5287b593a9c3e9291029e01020d86882',
                    'id_usser' => '1',
                    'fechagen' => '2023-02-13 02:57:05',
                )
            );
            foreach ($data as $datum){
                $token=new \App\Models\Token();
                $token->set_token($datum["token"]);
                $token->set_id_usser($datum["id_usser"]);
                $token->set_fechagen($datum["fechagen"]);
                $token->set();
            }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tor_token');
    }
}
