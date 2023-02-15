<?php

namespace App\Http\Controllers;


abstract class Login extends Controller {


    const RESPUESTA_CORRECTA = 1;
    const RESPUESTA_INCORRECTA = 0;
    
    public static $CUENTA;
    public static $USUARIO;
    private $metodo_actual;
    private $request_actual;

    public function despachar( $cosa = null) {
        $this->request_actual = $cosa;
        return call_user_func_array([$this, $this->metodo_actual], array($cosa));
    }

    public function callAction($method, $parameters) {
        $this->metodo_actual = $method;
        return call_user_func_array([$this, "despachar"], $parameters);
    }

}