<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helper;

/**
 * Description of Player
 *
 * @author adupuy
 */
class Player_man extends Player {
    private $fuerza;
    private $velocidad;
    public static function getInstance(){
        return new static();
    }
    
    public function get_fuerza() {
        return $this->fuerza;
    }

    public function get_velocidad() {
        return $this->velocidad;
    }

    public function set_fuerza($fuerza): self {
        $this->fuerza = $fuerza;
        return $this;
    }

    public function set_velocidad($velocidad): self {
        $this->velocidad = $velocidad;
        return $this;
    }
    public function toArray(): array {
       $response=parent::toArray();
       $response["velocidad"]= $this->velocidad;
       $response["fuerza"]= $this->fuerza;
       return $response;
   }

}
