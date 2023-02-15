<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 * Description of Torneo
 *
 * @author adupuy
 */
class Torneo extends Model{
    public static $id_tabla="id_torneo";
    private $id_torneo;
    private $id_usser;
    private $tipoTorneo;
    private $fecha;
    private $json_players;
    private $json_matchs;
    private $winner;
    
    public function get_id_torneo() {
        return $this->id_torneo;
    }

    public function get_id_usser() {
        return $this->id_usser;
    }

    public function get_tipoTorneo() {
        return $this->tipoTorneo;
    }

    public function get_fecha() {
        return $this->fecha;
    }

    public function get_json_players() {
        return $this->json_players;
    }

    public function get_json_matchs() {
        return $this->json_matchs;
    }

    public function get_winner() {
        return $this->winner;
    }

    public function json_players_decoded() {
        return json_decode($this->json_players,false);
    }

    public function json_matchs_decoded() {
        return json_decode($this->json_matchs,false);
    }

    public function winner_decoded() {
        return json_decode($this->winner,false);
    }

    public function set_id_torneo($id_torneo) {
        $this->id_torneo = $id_torneo;
        return $this;
    }

    public function set_id_usser($id_usser) {
        $this->id_usser = $id_usser;
        return $this;
    }

    public function set_tipoTorneo($tipoTorneo) {
        $this->tipoTorneo = $tipoTorneo;
        return $this;
    }

    public function set_fecha($fecha) {
        $this->fecha = $fecha;
        return $this;
    }

    public function set_json_players($json_players) {
        $this->json_players = $json_players;
        return $this;
    }

    public function set_json_matchs($json_matchs) {
        $this->json_matchs = $json_matchs;
        return $this;
    }

    public function set_winner($winner) {
        $this->winner = $winner;
        return $this;
    }




}
