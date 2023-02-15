<?php

namespace App\Models;


class Token Extends Model
{
    public static $id_tabla="id_token";
    private $id_token;
    private $token;
    private $id_usser;
    private $fechagen;
    
    
    public static function select_token_activo($usser){
        $variables["usser"]=$usser;
        $sql ="select * from tor_token where id_usser=? order by fechagen desc";
        return self::execute_select($sql, $variables,1);
    }
    
    public function get_id_token() {
        return $this->id_token;
    }

    public function get_token() {
        return $this->token;
    }

    public function get_id_usser() {
        return $this->id_usser;
    }

    public function get_fechagen() {
        return $this->fechagen;
    }

    public function set_id_token($id_token): void {
        $this->id_token = $id_token;
    }

    public function set_token($token): void {
        $this->token = $token;
    }

    public function set_id_usser($id_usser): void {
        $this->id_usser = $id_usser;
    }

    public function set_fechagen($fechagen): void {
        $this->fechagen = $fechagen;
    }






    
}
