<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \App\Models\Usser;

abstract class Controller extends BaseController 
{
    
    /** @var Usser Description
     */
    public static $USUARIO;
    private $metodo_actual;
    public static $HASH=ACTIVAR_HASH?true:false;
    const RESPUESTA_CORRECTA=1;
    const RESPUESTA_INCORRECTA=0;
    protected static $variables;

    public static function validar_entrada($variables, $parametros_validos){
        foreach ($variables as $clave=>$var){
            if(!in_array($clave, $parametros_validos)){
                return $clave;
            }
        }
        return false;
    }
    public static function normalizar_entrada($no_normalizar){
        foreach (self::$variables as $clave=>$var){
            if($var==null or ($clave=="image" and count($var)==1 and $var[0]==null)){
                unset(self::$variables[$clave]);
                continue;
            }
            if(!is_numeric($var) and !in_array($clave, $no_normalizar))
                self::$variables[$clave]= strtolower($var);
            elseif(!is_numeric ($var)){
                self::$variables[$clave]=$var;   
            }
        }
    }
    public function retornar($resultado,$log,$param=null){
        if(!$resultado){
            $response=json_encode(["log"=>$log]);
        }
        else{
            $response=json_encode($param);
        }
        return response($response)->header("Access-Control-Allow-Origin", "*")
                                  ->header("Content-Type", "application/json")
                                  ->header("Access-Control-Allow-Methods", "GET, POST, PUT,OPTIONS, DELETE")
                                  ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
    }
    public  function despachar( $cosa = null){
        
        return call_user_func_array([$this, $this->metodo_actual],array($cosa));
    }

    public function callAction($method, $parameters)
    {
        
        $this->metodo_actual=$method;
        if(isset($parameters[0]))
            $this->cargar_parametros($parameters[0]->json()->all());
        else
            $parameters=[array_pop($parameters)];
        
        try{
            return call_user_func_array([$this, "despachar"], $parameters);
        
        } catch (\Exception $e){
            developer_log($e);
            return $this->retornar(false, $e->getTrace());
        }
    }
    public static function cargar_parametros($parametros){
        if(self::$variables==null)
            self::$variables=$parametros;
        else
            self::$variables=array_merge(self::$variables,$parametros);
    }
    public static function set_cuenta($token){
        $rs= \Token::select(array("token"=>$token));
        $row =$rs->fetchRow();
        self::$USUARIO = new Usser();
        self::$USUARIO->get($row["id_usser"]);
        if(self::$USUARIO->get_id_usser()==null){
            return false;
        }
        return true;
    }
}
