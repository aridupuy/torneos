<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Model;
use App\Models\Usser;
use App\Models\Token;
use App\Http\Controllers\Controller;
class Authenticate {

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next) {
        if(!$this->validarToken($request)){
            return \Illuminate\Http\Response::create("Access denied", 404, []);
        }
        return $next($request)->header("Access-Control-Allow-Origin", "*")
                        //Métodos que a los que se da acceso
                        ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE")
                        //Headers de la petición
                        ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
    }
    private function validarToken(\Illuminate\Http\Request $request) {
        $rs= Token::select(array("token"=>$request->header("token")));
        if($rs->rowCount()==0){
            return false;
        }
        $row =$rs->fetchRow();
        Controller::$USUARIO = new Usser();
        Controller::$USUARIO->get($row["id_usser"]);
        if(Controller::$USUARIO->get_id_usser()==null){
            return false;
        }
        return true;
    }

}