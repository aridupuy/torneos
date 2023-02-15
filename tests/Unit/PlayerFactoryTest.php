<?php

namespace Tests\Unit;
use Tests\FrameworkTestCase;
use \App\Providers\PlayerFactoryProvider;
use App\Factory\PlayerManFactory;
use App\Factory\PlayerWomanFactory;
class PlayerFactoryTest extends FrameworkTestCase 
{
    
    public function test_PlayerFactoryForMans(){
        $playersFactory=new PlayerFactoryProvider();
        $fakeTorneo= $this->getFakeTorneoMans();
        $playerFactory=$playersFactory->provide($fakeTorneo);
        $this->assertEquals(PlayerManFactory::class, get_class($playerFactory));
    }
    
    public function test_PlayerFactoryForWomans(){
        $playersFactory=new PlayerFactoryProvider();
        $fakeTorneo = $this->getFakeTorneoWomans();
        $playerFactory=$playersFactory->provide($fakeTorneo);
        $this->assertEquals(PlayerWomanFactory::class, get_class($playerFactory));
    }
    
}
