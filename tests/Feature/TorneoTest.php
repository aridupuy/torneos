<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FrameworkTestCase;

class TorneoTest extends FrameworkTestCase {
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_PostTorneoWithoutAuthenticationShouldFail(){
        $this->refreshApplication();
        $fakeData = $this->getFakeTorneoRequest();
        $header = [];
        $response = $this->postJson('api/v1/torneo',$fakeData,$header);
        $response->assertStatus(404);
        $this->assertEquals("Access denied", $response->baseResponse->content());
    }
    
    public function test_PostTorneoCalculateSuccess()
    {
        $fakeData = $this->getFakeTorneoRequest();
        $header = $this->getFakeHeaders();
        $response = $this->postJson('api/v1/torneo',$fakeData,$header);
        $response->assertStatus(200);
        $this->assertStringContainsString("players", $response->baseResponse->getContent());
        $this->assertStringContainsString("matchs", $response->baseResponse->getContent());
        $this->assertStringContainsString("champion", $response->baseResponse->getContent());
    }
    
    public function test_PostTorneosRetrieverSuccess()
    {
        $header = $this->getFakeHeaders();
        $response = $this->get('api/v1/torneos',$header);
        $response->assertStatus(200);
        $this->assertGreaterThan(0, count($response->json()));
        $this->assertStringContainsString("tipoTorneo",(string)  $response->baseResponse->getContent());
        $this->assertStringContainsString("winner", (string)  $response->baseResponse->getContent());
        $this->assertStringContainsString("fecha",(string) $response->baseResponse->getContent());
        $this->assertStringContainsString("id_usser",(string) $response->baseResponse->getContent());
    }
    
    public function test_PostTorneosRetrieverOneSuccess()
    {
        $header = $this->getFakeHeaders();
        $response = $this->get('api/v1/torneo/1',$header);
        $response->assertStatus(200);
        $this->assertGreaterThan(0, count($response->json()));
        $this->assertGreaterThan(0, count($response->json()));
        
    }
    
    private function getFakeTorneoRequest() {
        return json_decode($this->getFakeJsonRequest(),true);
    }
    
    private function getFakeJsonRequest(){
        return <<<JSON
{
	"players":[{
		"nombre":"jorge",
		"habilidad":"15",
		"fuerza":"15",
		"velocidad":"45"
	},
	{
		"nombre":"juan",
		"habilidad":"17",
		"fuerza":"20",
		"velocidad":"56"
	},
	{
		"nombre":"roberto",
		"habilidad":"24",
		"fuerza":"45",
		"velocidad":"90"
	},
	{
		"nombre":"jose",
		"habilidad":"35",
		"fuerza":"59",
		"velocidad":"15"
	},
	{
		"nombre":"ricardo",
		"habilidad":"10",
		"fuerza":"80",
		"velocidad":"50"
	},
	{
		"nombre":"horacio",
		"habilidad":"19",
		"fuerza":"14",
		"velocidad":"35"
	},
	{
		"nombre":"eduardo",
		"habilidad":"1",
		"fuerza":"35",
		"velocidad":"11"
	},
	{
		"nombre":"ariel",
		"habilidad":"25",
		"fuerza":"89",
		"velocidad":"15"
	}
	],
	
	"torneo":{
		"tipo":"h"
	}
} 
JSON;
    }
    public function getFakeHeaders(){
        return ["token"=>"c68df523fef6e357da5287b593a9c3e9291029e01020d86882"];
    }
}
