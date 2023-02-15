<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helper;

/**
 * Description of Players
 *
 * @author adupuy
 */
abstract class Player {
    private $nombre;
    private $habilidad;
    private $suerte;
    
    
    
    public function get_nombre() {
        return $this->nombre;
    }

    public function get_habilidad() {
        return $this->habilidad;
    }

    public function get_suerte() {
        return $this->suerte;
    }

    public function set_nombre($nombre): self {
        $this->nombre = $nombre;
        return $this;
    }

    public function set_habilidad($habilidad):  self {
        $this->habilidad = $habilidad;
        return $this;
    }

    public function set_suerte($suerte): self {
        $this->suerte = $suerte;
        return $this;
    }

    public function toArray(): array {
        return ["nombre"=>$this->nombre,"habilidad"=>$this->habilidad,"suerte"=>$this->suerte];
    }
    public function toJson(): string {
        return json_encode($this->toArray());
    }
    
}
