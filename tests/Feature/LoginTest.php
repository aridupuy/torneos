<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FrameworkTestCase;

class LoginTest extends FrameworkTestCase {
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_AuthControllerShouldFalse()
    {
        $fakeData = $this->getFakeRequest();
        $response = $this->postJson('api/v1/login',$fakeData);
        $response->assertStatus(200);
        $this->assertEquals(false, $response->json("resultado"));
        $this->assertEquals("Error en credenciales.", $response->json("log"));
    }
    
    
    
    private function getFakeRequest() {
        return json_decode($this->getFakeJsonRequest(),true);
    }
    private function getFakeJsonRequest(){
        return <<<JSON
 {
	
	"usuario":"saraza",
	"clave":"1234"
}
JSON;
    }
}
