<?php

namespace App\Models;


class Usser Extends Model
{
    public static $id_tabla="id_usser";
    private $id_usser;
    private $usser;
    private $password;
    
    public static function select_login($usser,$password){
        $variables["usser"]=$usser;
        $variables["password"]=$password;
        $sql ="select * from tor_usser where usser=? and password=?";
        return self::execute_select($sql, $variables);
    }
    
    public function get_id_usser() {
        return $this->id_usser;
    }

    public function get_usser() {
        return $this->usser;
    }

    public function get_password() {
        return $this->password;
    }

    public function set_id_usser($id_usser): void {
        $this->id_usser = $id_usser;
    }

    public function set_usser($usser): void {
        $this->usser = $usser;
    }

    public function set_password($password): void {
        $this->password = $password;
    }




    
}
