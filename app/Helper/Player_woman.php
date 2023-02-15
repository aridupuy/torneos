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
class Player_woman extends Player {
   private $tiempoReaccion;
   
    public static function getInstance(){
        return new static();
    }
    
   public function get_tiempoReaccion() {
       return $this->tiempoReaccion;
   }

   public function set_tiempoReaccion($tiempoReaccion): self {
       $this->tiempoReaccion = $tiempoReaccion;
       return $this;
   }
   
   public function toArray(): array {
       $response=parent::toArray();
       $response["tiempoReaccion"]= $this->tiempoReaccion;
       return $response;
   }

    
}
