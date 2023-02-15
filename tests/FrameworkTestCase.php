<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Helper\Torneo;
use \App\Helper\Player_man;
use App\Helper\Player_woman;
use App\Helper\Player;

abstract class FrameworkTestCase extends TestCase{

    use CreatesApplication;

    
    public function getFakeTorneoMans(): Torneo {
        return (new Torneo(["tipo" => "h"]))
                        ->with_player($this->retrieveFakePlayerMan())
                        ->with_player($this->retrieveFakePlayerMan())
                        ->with_player($this->retrieveFakePlayerMan())
                        ->with_player($this->retrieveFakePlayerMan());
    }

    public function getFakeTorneoWomans(): Torneo {
        return (new Torneo(["tipo" => "m"]))
                        ->with_player($this->retrieveFakePlayerWoman())
                        ->with_player($this->retrieveFakePlayerWoman())
                        ->with_player($this->retrieveFakePlayerWoman())
                        ->with_player($this->retrieveFakePlayerWoman());
    }

    public function retrieveFakePlayerMan(): Player {
        $faker = new \Faker\Factory();

        return (new Player_man())->set_fuerza($faker->create()->numberBetween(1, 100))
                        ->set_velocidad($faker->create()->numberBetween(1, 100))
                        ->set_habilidad($faker->create()->numberBetween(1, 100))
                        ->set_suerte($faker->create()->numberBetween(1, 100))
                        ->set_nombre($faker->create()->name("m"));
    }

    public function retrieveFakePlayerWoman(): Player {
        $faker = new \Faker\Factory();

        return (new Player_woman())->set_tiempoReaccion($faker->create()->numberBetween(0, 2))
                        ->set_habilidad($faker->create()->numberBetween(1, 100))
                        ->set_suerte($faker->create()->numberBetween(1, 100))
                        ->set_nombre($faker->create()->name("w"));
    }
    
    public function retrieveFakeWinnerPlayerWoman(): Player {
        return (new Player_woman())->set_tiempoReaccion(0)
                        ->set_habilidad(100)
                        ->set_suerte(100)
                        ->set_nombre("Ganadora 1");
    }
    public function retrieveFakeLooserPlayerWoman(): Player {
        return (new Player_woman())->set_tiempoReaccion(1000)
                        ->set_habilidad(0)
                        ->set_suerte(0)
                        ->set_nombre("Perdedora 1");
    }
    
    public function retrieveFakeWinnerPlayerMan(): Player {
        return (new Player_man())->set_velocidad(100)
                        ->set_fuerza(100)
                        ->set_habilidad(100)
                        ->set_suerte(100)
                        ->set_nombre("Ganador 1");
    }
    
    public function retrieveFakeLooserPlayerMan(): Player {
        return (new Player_man())->set_velocidad(0)
                        ->set_fuerza(0)
                        ->set_habilidad(0)
                        ->set_suerte(0)
                        ->set_nombre("Perdedor 1");
    }

}
