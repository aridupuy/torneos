<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Factory;
use App\Helper\Torneo ;
use \App\Helper\Player_woman;
use \App\Helper\Player_man;
/**
 * Description of PlayerWomanFactory
 *
 * @author adupuy
 */
class PlayerWomanFactory extends PlayersFactory{
    private $tiempoReaccion;
    public function build() {
        return (new Player_woman())
                ->set_tiempoReaccion($this->tiempoReaccion)
                ->set_nombre($this->nombre)
                ->set_habilidad($this->habilidad)
                ->set_suerte($this->suerte);
    }
    public function prepare(array $player): self {
        return parent::prepare($player)->with_tiempoReaccion(isset($player["tiempoReaccion"])?$player["tiempoReaccion"]:null);
    }
    
    public function with_tiempoReaccion($tiempoReaccion): self {
        $this->tiempoReaccion = $tiempoReaccion;
        return $this;
    }
    
}
