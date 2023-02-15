<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helper;
/**
 * Description of sexoEnum
 *
 * @author adupuy
 */
class tipoTorneoEnum{
/**
* @method static self HOMBRES()
* @method static self MUJERES()
*/
    public const HOMBRES = "h";
    public const MUJERES = "m";
    
    public static function fromVars($tipo){
        if(in_array($tipo, [self::HOMBRES, self::MUJERES]))
            return $tipo;
        Throw new \Exception("Valor inválido");
    }   
}
