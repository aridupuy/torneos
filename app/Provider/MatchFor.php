<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Provider;
use App\Helper\Player;
use App\Helper\Torneo;
/**
 *
 * @author adupuy
 */
abstract class MatchFor {
    protected Torneo $torneo;
    
    public function __construct(Torneo $torneo) {
        $this->torneo=$torneo;
    }
    public abstract function winner(Player $uno , Player $dos): Player;
    
    protected function getMoreLucky(Player $primero, Player $segundo) {
        return array($primero,$segundo)[random_int(0,1)];
    }
}
