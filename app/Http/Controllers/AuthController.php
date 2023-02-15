<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

//require 'log_in.php';

use Illuminate\Http\Request;
//use Usuario;
use App\Models\Usser;
//use Cuenta_usuario;
use App\Models\Token;
use Exception;

/**
 * Description of AuthController
 *
 * @author ariel
 */
class AuthController extends Login {

    const PARAMETROS_VALIDOS = [
        "email", "password", "first_name", "last_name", "location", "contact", "rating","profile_pic","longitud","latitud"
    ];

    public function login(Request $request) {
        try {
            $variables=$request->json()->all();
            if(($variables!=null or  count($variables)==0) and isset($request->all()["application/json"])){
               $variables=json_decode($request->all()["application/json"],true);
            }
	    else{
		$variables=$request->all();	
	    }
            
            return response()->json(
                                    $this->loginAction($variables)
                            )->header("Access-Control-Allow-Origin", "*")
                            //Métodos que a los que se da acceso
                            ->header("Access-Control-Allow-Methods", "GET, POST, PUT,OPTIONS, DELETE")
                            //Headers de la petición
                            ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
            ;
        } catch (Exception $e) {
            return response()->json(["resultado" => false, "log" => $e->getMessage(), "tokenError" => ""]);
        }
    }

    public function checkToken(Request $request) {
	$variables=$request->json()->all();
            if(($variables!=null or  count($variables)==0) and isset($request->all()["application/json"])){
               $variables=json_decode($request->all()["application/json"],true);
            }
            else{
                $variables=$request->all();
            }
        if (is_array($variables) and isset($variables["ct"]) and isset($variables["iv"]) and isset($variables["s"])) {
            $hash = new \Gestor_de_hash(self::CLAVE_CIFRADO);
            $variables = $hash->cryptoJsAesDecrypt(json_encode($variables));
        } else if (count($variables) == 1) {
            $hash = new \Gestor_de_hash(self::CLAVE_CIFRADO);
            $variables = $hash->cryptoJsAesDecrypt($variables[0]);
        }
        $response = $hash->cryptoJsAesEncrypt(self::CLAVE_DE_ENCRIPTACION, json_encode(["check" => Token::checktoken($variables["token"])]));
        return response($response)->header("Access-Control-Allow-Origin", "*")
                        //Métodos que a los que se da acceso
                        ->header("Access-Control-Allow-Methods", "GET, POST, PUT,OPTIONS, DELETE")
                        //Headers de la petición
                        ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
    }

    public function loginAction($variables) {
        if (!isset($variables["usuario"]) and!isset($variables["clave"])) {
            throw new Exception("Error en credenciales.");
        }
        $rs_usuario = Usser::select_login($variables["usuario"], $variables["clave"]);
        $usuario = new Usser($rs_usuario->fetchRow());
        if ($usuario->get_id() == false) {
            throw new Exception("Error en credenciales.");
        }
        $rs = Token::select_token_activo($usuario->get_id());
        if ($rs->rowCount() > 0) {

            $token = new Token($rs->fetchRow());
            $array["token"] = $token->get_token();
            $array["info"] = "reutilizado";
            
        } else {

            $array["token"] = bin2hex(random_bytes(25));
            $array["info"] = "Creado nuevo";
            $token = new Token();
            $token->set_id_usser($usuario->get_id());
            $token->set_token($array["token"]);
            $token->set_fechagen(now());
        }
        
        if ($token->set()) {
            $array["valido_hasta"] = "Tras " . INTERVALO_SESION . " minutos de inactividad.";
            $array["id_usser"] = $usuario->get_id_usser();
            
        } else {
            
            throw new Exception("Error al guardar token ");
        }
        
        if ($array) {
            return $array;
        }
        throw new Exception("Error al autenticar. Verifique credenciales");
    }

    public function loginwithtoken(Request $request) {
	$variables=$request->json()->all();
        if(($variables!=null or  count($variables)==0) and isset($request->all()["application/json"])){
               $variables=json_decode($request->all()["application/json"],true);
        }
        else{
                $variables=$request->all();
        }
        if (is_array($variables) and isset($variables["ct"]) and isset($variables["iv"]) and isset($variables["s"])) {
            $hash = new \Gestor_de_hash(self::CLAVE_CIFRADO);
            $variables = $hash->cryptoJsAesDecrypt(json_encode($variables));
        } else if (count($variables) == 1) {
            $hash = new \Gestor_de_hash(self::CLAVE_CIFRADO);
            $variables = $hash->cryptoJsAesDecrypt($variables[0]);
        }
//        developer_log(json_encode($variables));
        $token = Token::select_token_with_token($variables["token"]);
        if (!$token) {
            $array["token"] = false;
            $array["log"] = "Error al autenticar. Verifique credenciales";
            $array["resultado"] = false;
            $response = $hash->cryptoJsAesEncrypt(self::CLAVE_DE_ENCRIPTACION, json_encode($array));
            return response($response);
        }
        $token->set_ultimo_uso("null");
        $token->set();
//        }
//        else{
//            $array["token"]=false;
//            $array["log"]="Error al autenticar. Verifique credenciales";
//            $array["resultado"]=false;
//            $response=$hash->cryptoJsAesEncrypt(self::CLAVE_DE_ENCRIPTACION, json_encode($array));
//            return response($response);
//        }
        $token_anterior = $token;
        $rs = Token::select_token_activo($token_anterior->get_id_cuenta_usuario());

        if ($rs->rowCount() > 0) {

            $token = new Token($rs->fetchRow());
            $array["token"] = $token->get_token();
            $token->set_ultimo_uso("now()");
        } else {

            $array["token"] = bin2hex(random_bytes(25));
            $token = new Token();
            $token->set_id_cuenta_usuario($token_anterior->get_id_cuenta_usuario());
            $token->set_token($array["token"]);
            $token->set_fecha_gen("now()");
            $token->set_ultimo_uso("now()");
        }

        if ($token->set()) {
            $array["valido_hasta"] = "Tras " . INTERVALO_SESION_EXTENDIDO . " dias de inactividad.";
            $response = $hash->cryptoJsAesEncrypt(self::CLAVE_DE_ENCRIPTACION, json_encode($array));
            return response($response)->header("Access-Control-Allow-Origin", "*")
                            //Métodos que a los que se da acceso
                            ->header("Access-Control-Allow-Methods", "GET, POST, PUT,OPTIONS, DELETE")
                            //Headers de la petición
                            ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
            ;
        }

        return response(false)->header("Access-Control-Allow-Origin", "*")
                        //Métodos que a los que se da acceso
                        ->header("Access-Control-Allow-Methods", "GET, POST, PUT,OPTIONS, DELETE")
                        //Headers de la petición
                        ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
        ;
    }

    /*public function register(Request $request) {
        
	$variables=$request->json()->all();
        if(($variables!=null or  count($variables)==0) and isset($request->all()["application/json"])){
             $variables=json_decode($request->all()["application/json"],true);
        }
        else{
            $variables=$request->all();
        }
	self::$variables=$variables;
        $usser = new Usser();
        if (($clave = self::validar_entrada(self::$variables, self::PARAMETROS_VALIDOS)) !== false) {
            return $this->retornar(false, "Error el parametro $clave no es valido", null);
        }
        self::normalizar_entrada(["password","profile_pic"]);
        $usser->set_email(self::$variables["email"]);
        $usser->set_password(calcular_password(self::$variables["password"]));
        $usser->set_first_name(self::$variables["first_name"]);
        $usser->set_last_name(self::$variables["last_name"]);
        $usser->set_location(self::$variables["location"]);
        $usser->set_contact(self::$variables["contact"]);
        $usser->set_rating(self::$variables["rating"]);
        $usser->set_latitud(self::$variables["latitud"]);
        $usser->set_longitud(self::$variables["longitud"]);
        $profile_pic = $this->tratar_imagen(self::$variables["profile_pic"]);
        $usser->set_profile_pic($profile_pic);
        if ($usser->set()) {
            return $this->retornar(true, "Creado Correctamente", ["result" => true, "id" => $usser->get_id(), "log" => "Creado Correctamente"]);
        } else {
            return $this->retornar(false, "Error al crear Usser", []);
        }
    }*/
    
}
