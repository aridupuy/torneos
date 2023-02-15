<?php
namespace App\Provider;

use App\Helper\Torneo;
use App\Helper\tipoTorneoEnum;
/**
 * Description of MatchProvider
 *
 * @author adupuy
 */
class MatchProvider {
    
    const providers=[
        tipoTorneoEnum::HOMBRES=>MatchForMan::class,
        tipoTorneoEnum::MUJERES=>MatchForWoman::class
    ];
    
    public static function provide(Torneo $torneo) : MatchFor{
        $provider = self::providers[tipoTorneoEnum::fromVars($torneo->tipoTorneo)];
        return new $provider($torneo);
    }
}
