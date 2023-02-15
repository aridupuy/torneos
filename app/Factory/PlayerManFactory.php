<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Factory;

use \App\Helper\Player_man;
/**
 * Description of PlayerManFactory
 *
 * @author adupuy
 */
class PlayerManFactory extends PlayersFactory{
    private $fuerza;
    private $velocidad;
    //put your code here
    public function prepare(array $player): self {
        return parent::prepare($player)->with_fuerza(isset($player["fuerza"])?$player["fuerza"]:null)
             ->with_velocidad(isset($player["velocidad"])?$player["velocidad"]:null);
    }
    public function with_fuerza($fuerza): self {
        $this->fuerza = $fuerza;
        return $this;
    }

    public function with_velocidad($velocidad): self {
        $this->velocidad = $velocidad;
        return $this;
    }
    public function build() {
        return (new Player_man())
                ->set_fuerza($this->fuerza)
                ->set_velocidad($this->velocidad)
                ->set_nombre($this->nombre)
                ->set_habilidad($this->habilidad)
                ->set_suerte($this->suerte);
    }

}
