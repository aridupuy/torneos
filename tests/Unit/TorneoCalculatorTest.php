<?php

namespace Tests\Unit;
use App\Helper\Torneo;
use \App\Providers\PlayerFactoryProvider;
use \App\Helper\Player;
use \App\Helper\Player_man;
use App\Helper\Player_woman;
use \Tests\FrameworkTestCase;

class TorneoCalculatorTest extends FrameworkTestCase {
    
    public function test_TorneoCalculatorForMans(){
        $fakeTorneo = $this->getFakeTorneoMans();
        $fakeTorneo->processTournament();
        $this->assertEquals(false, $fakeTorneo->deMujeres());
        $this->assertGreaterThan(4, $fakeTorneo->matchs);
        $this->assertCount(4, $fakeTorneo->players);
        $this->assertNotEquals(null, $fakeTorneo->champion);
    }
    
    
    
    public function test_TorneoCalculatorForWomans(){
        $fakeTorneo = $this->getFakeTorneoWomans();
        $fakeTorneo->processTournament();
        $this->assertEquals(true, $fakeTorneo->deMujeres());
        $this->assertGreaterThan(4, $fakeTorneo->matchs);
        $this->assertCount(4, $fakeTorneo->players);
        $this->assertNotEquals(null, $fakeTorneo->champion);
    }
    
}
