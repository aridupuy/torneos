<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helper;

/**
 * Description of Match
 *
 * @author adupuy
 */
class __Match {
    /** @var Player player A
     */
    private $playerA;
    /** @var Player player B
     */
    private $playerB;
    /** @var Player Winner
     */
    private $winner;
    /** @var int points of playerA
     */
    private $pointsA;
    
    /** @var int points of playerB
    */
    private $pointsB;
    
    //put your code here
    public function get_playerA(): Player {
        return $this->playerA;
    }

    public function get_playerB(): Player {
        return $this->playerB;
    }

    public function get_winner(): Player {
        return $this->winner;
    }

    public function set_playerA(Player $playerA): void {
        $this->playerA = $playerA;
    }

    public function set_playerB(Player $playerB): void {
        $this->playerB = $playerB;
    }

    public function set_winner(Player $winner): void {
        $this->winner = $winner;
    }
    public function get_pointsA(): int {
        return $this->pointsA;
    }

    public function get_pointsB(): int {
        return $this->pointsB;
    }

    public function set_pointsA(int $pointsA): void {
        $this->pointsA = $pointsA;
    }

    public function set_pointsB(int $pointsB): void {
        $this->pointsB = $pointsB;
    }

    public function __construct(Player $a, Player $b,int $pointA,$pointB, Player $winner) {
        $this->set_playerA($a);
        $this->set_playerB($b);
        $this->set_pointsA($pointA);
        $this->set_pointsB($pointB);
        $this->set_winner($winner);
    }
    public function toArray(): array{
        return ["player1"=> $this->get_playerA()->toArray(),
                "player2"=> $this->playerB->toArray(),
                "point1"=> $this->pointsA,
                "point2"=> $this->pointsB,
                "winner"=> $this->winner->toArray()
                ];
    }
    public function toJson(): string {
        return json_encode($this->toArray(),JSON_UNESCAPED_SLASHES);
    }

}
