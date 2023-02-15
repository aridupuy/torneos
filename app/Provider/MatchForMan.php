<?php
namespace App\Provider;

use App\Helper\Player;
use App\Helper\__Match;
/**
 * Description of MatchForMan
 *
 * @author adupuy
 */
class MatchForMan extends MatchFor {
    
    public function winner(Player $uno , Player $dos): Player{
        $puntosA=$uno->get_habilidad()+
               $uno->get_suerte()+
               $uno->get_fuerza()+
               $uno->get_velocidad();
        $puntosB=$dos->get_habilidad()+
                 $dos->get_suerte()+
                 $uno->get_fuerza()+
                 $uno->get_velocidad();
        $winner=$puntosA>$puntosB?$uno:$dos;
        $this->torneo->addmatchs(new __Match($uno,$dos,$puntosA,$puntosB,$winner));
        return $winner;
    }
}
