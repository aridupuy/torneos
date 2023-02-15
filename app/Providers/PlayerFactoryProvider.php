<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Providers;

use \App\Factory\PlayersFactory;
use App\Factory\PlayerManFactory;
use App\Factory\PlayerWomanFactory;
use App\Helper\Torneo;
use \App\Helper\tipoTorneoEnum;

/**
 * Description of PlayerFactoryProvider
 *
 * @author adupuy
 */
class PlayerFactoryProvider {
    const providers=[
        tipoTorneoEnum::HOMBRES=>PlayerManFactory::class,
        tipoTorneoEnum::MUJERES=>PlayerWomanFactory::class,
    ];
    public static function provide(Torneo $torneo): PlayersFactory {
      $provider = self::providers[tipoTorneoEnum::fromVars($torneo->tipoTorneo)];
      return new $provider();
    }
}
