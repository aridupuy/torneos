<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helper;
use \App\Provider\MatchProvider;
/**
 * Description of Torneo
 *
 * @author adupuy
 */
class Torneo {
    /** @var tipoTorneoEnum tipo de torneo 
     */
    public $tipoTorneo;
    /** @var Player[] jugadores 
     */
    public  $players;
    /** @var __Match[] partidos
     */
    public $matchs;
    
    /** @var Player ganador
     */
    public  $champion;
    
    public function __construct(array $torneo) {
        $this->tipoTorneo= tipoTorneoEnum::fromVars($torneo["tipo"]);
    }
    public function deMujeres(): bool {
        return $this->tipoTorneo==tipoTorneoEnum::MUJERES;
    }
    /** @param Players $players jugadores del torneo
     */
    public function with_player(Player $player){
        $this->players[]=$player;
        return $this;
    }
    
    public function getWinner(Player $uno , Player $dos){
        return MatchProvider::provide($this)->winner($uno, $dos);
        
    }
    public function addmatchs(__Match $match){
        $this->matchs[]=$match;
        return $this;
    }
    
    public function processTournament() {
        /*algoritmo del torneo*/
        $this->champion = $this->process($this->players);
        return ;
    }
    private function process($players){
        if(count($players)==1){
            return $players[0];
        }
        while(count($players)>0){
            $last = count($players)-1;
            $winners[]= $this->getWinner($players[0], $players[$last]);
            unset($players[0]);
            unset($players[$last]);
            $players= array_values($players);
        }
        return $this->process($winners);
    }
    public function toArray(): array{
        $response["tipoTorneo"]= $this->tipoTorneo;
        $response["players"]= array_map(function(Player $players){
            return $players->toArray();
        },$this->players);
        $response["matchs"]=array_map(function(__Match $match){
            return $match->toArray();
        },$this->matchs);
        $response["champion"]=$this->champion->toArray();
        return $response;
    }
    
    public function getJsonPlayers(){
        return json_encode(array_map(function(Player $players){
            return $players->toJson();
        }, $this->players));
    }
    public function getJsonMatchs(){
        return json_encode(array_map(function(__Match $match){
            return $match->toJson();
        }, $this->matchs));
    }
    
}
