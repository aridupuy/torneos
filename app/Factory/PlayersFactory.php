<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Factory;

/**
 * Description of PlayersFactory
 *
 * @author adupuy
 */
use App\Helper\Player_woman;
use App\Helper\Player_man;
use App\Helper\Torneo;

abstract class PlayersFactory {
    protected $nombre;
    protected $habilidad;
    protected $suerte;
    
    
    public function prepare(array $player): self{
        
        return $this->with_habilidad(isset($player["habilidad"])?$player["habilidad"]:null)
             ->with_nombre(isset($player["nombre"])?$player["nombre"]:null)
             ->with_suerte(isset($player["suerte"])?$player["suerte"]:null);
    }
    
    public function with_nombre($nombre): self {
        $this->nombre = $nombre;
        return $this;
    }

    public function with_habilidad($habilidad): self {
        $this->habilidad = $habilidad;
        return $this;
    }

    public function with_suerte($suerte): self {
        $this->suerte = $suerte;
        return $this;
    }
   
}
