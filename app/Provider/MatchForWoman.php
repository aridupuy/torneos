<?php
namespace App\Provider;

use App\Helper\Player;
use App\Helper\Torneo;
use App\Helper\__Match;
class MatchForWoman extends MatchFor{
    
    public function winner(Player $uno , Player $dos): Player{
        $puntosA =  $uno->get_habilidad()+
                    $uno->get_suerte()+
                    $uno->get_tiempoReaccion()*-1;
        
        $puntosB =  $dos->get_habilidad()+
                    $dos->get_suerte()+
                    $dos->get_tiempoReaccion()*-1;
        $winner = $puntosA==$puntosB
                    ?$this->getMoreLucky($uno, $dos)
                    :$puntosA>$puntosB
                        ?$uno
                        :$dos;
        $this->torneo->addmatchs(new __Match($uno,$dos,$puntosA,$puntosB,$winner));
        return $winner;
    }
}
