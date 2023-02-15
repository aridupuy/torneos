<?php

namespace Tests\Unit;
use Tests\FrameworkTestCase;
use \App\Providers\PlayerFactoryProvider;
use App\Factory\PlayerManFactory;
use App\Factory\PlayerWomanFactory;
use \App\Provider\MatchProvider;
use \App\Provider\MatchForMan;
use \App\Provider\MatchForWoman;

class MatchProviderTest extends FrameworkTestCase 
{
    
    public function test_MatchProviderForMans(){
        $fakeTorneo= $this->getFakeTorneoMans();
        $match=MatchProvider::provide($fakeTorneo);
        $this->assertEquals(MatchForMan::class, get_class($match));
    }
    
    public function test_MatchProviderForWomans(){
        $fakeTorneo = $this->getFakeTorneoWomans();
        $match=MatchProvider::provide($fakeTorneo);
        $this->assertEquals(MatchForWoman::class, get_class($match));
    }
    
    public function test_MatchWomansWinner(){
        $fakeTorneo = $this->getFakeTorneoWomans();
        $match=MatchProvider::provide($fakeTorneo);
        $playerWinner=$this->retrieveFakeWinnerPlayerWoman();
        $playerLooser=$this->retrieveFakeLooserPlayerWoman();
        $winnerMatch= $match->winner($playerWinner, $playerLooser);
        $this->assertEquals( $playerWinner, $winnerMatch);
        $this->assertNotEquals( $playerLooser, $winnerMatch);
    }
    
    public function test_MatchMansWinner(){
        $fakeTorneo = $this->getFakeTorneoMans();
        $match=MatchProvider::provide($fakeTorneo);
        $playerWinner=$this->retrieveFakeWinnerPlayerMan();
        $playerLooser=$this->retrieveFakeLooserPlayerMan();
        $winnerMatch= $match->winner($playerWinner, $playerLooser);
        
        $this->assertEquals( $playerWinner, $winnerMatch);
        
    }
    
}
