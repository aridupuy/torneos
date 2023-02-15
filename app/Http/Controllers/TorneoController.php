<?php
namespace App\Http\Controllers;
use \Illuminate\Http\Request;
use App\Helper\Torneo as TorneoHelper;
use App\Models\Torneo as TorneoModel;
use App\Factory\PlayersFactory;
use \App\Providers\PlayerFactoryProvider;
/**
 * Description of TorneoController
 *
 * @author adupuy
 */
class TorneoController extends Controller{
    //put your code here
    const PARAMETROS_VALIDOS=[
        "players","torneo"
    ];
    
    public function Torneo(Request $request){
        if($this->validar_entrada(self::$variables, self::PARAMETROS_VALIDOS))
            return $this->retornar(false,"Parametros inválidos", []);
        if(count(self::$variables["players"])%2 !== 0){
            return $this->retornar(false,"La cantidad de jugadores no es correcta", []);
        }
        $torneo = new TorneoHelper(self::$variables["torneo"]);
        foreach (self::$variables["players"] as $player){
            $this->registerInTorneo($torneo, $player);   
        }
        $torneo->processTournament();
        if(!$this->saveResult($torneo))
            return $this->retornar(false, ["Falla al calcular torneo"], []);
        
        return $this->retornar(true, ["Torneo calculado"], $torneo->toArray());
        
    }
    
    public function getTorneos(Request $request){
        $rs = TorneoModel::select();
        if($rs->rowCount()==0){
            return $this->retornar(false, "No se registran torneos");
        }
        foreach ($rs as $row){
            $response[]=[
                        "id_torneo"=> $row["id_torneo"],
                        "winner"=> json_decode($row["winner"],false)->nombre,
                        "id_usser"=>$row["id_usser"],
                        "tipoTorneo"=>$row["tipoTorneo"],
                        "fecha"=> \DateTime::createFromFormat("Y-m-d H:i:s", $row["fecha"])->format("Y-m-d"),
                        ];
        }
        return $this->retornar(true, "",$response);
    }
    
    public function getTorneo($id){
        
        $tModel = new TorneoModel();
        $tModel->get($id);
        if($tModel->getId()!=$id){
            return $this->retornar(false, "El torneo no existe");
        }
        $response[]=[
                    "id_torneo"=> $tModel->get_id_torneo(),
                    "id_usser"=>$tModel->get_id_usser(),
                    "tipoTorneo"=>$tModel->get_tipoTorneo(),
                    "fecha"=> \DateTime::createFromFormat("Y-m-d H:i:s", $tModel->get_fecha())->format("Y-m-d"),
                    "winner"=> $this->obtener_winner($tModel->winner_decoded()),
                    "players"=> $this->obtener_players($tModel->json_players_decoded()),
                    "matchs"=> $this->obtener_matchs($tModel->json_matchs_decoded()),
        ];
        return $this->retornar(true, "",$response);
    } 
    
    public function getWinner($id){
        if(!($tModel=$this->getModel($id))){
            return $this->retornar(false, "El torneo no existe");
        }
        $response[]=[
                    "id_torneo"=> $tModel->get_id_torneo(),
                    "tipoTorneo"=>$tModel->get_tipoTorneo(),
                    "fecha"=> \DateTime::createFromFormat("Y-m-d H:i:s", $tModel->get_fecha())->format("Y-m-d"),
                    "winner"=> $this->obtener_winner($tModel->winner_decoded()),
                    
        ];
        return $this->retornar(true, "",$response);
    }
    public function getPlayers($id){
        if(!($tModel=$this->getModel($id))){
            return $this->retornar(false, "El torneo no existe");
        }
        $response[]=[
                    "id_torneo"=> $tModel->get_id_torneo(),
                    "tipoTorneo"=>$tModel->get_tipoTorneo(),
                    "fecha"=> \DateTime::createFromFormat("Y-m-d H:i:s", $tModel->get_fecha())->format("Y-m-d"),
                    "players"=> $this->obtener_players($tModel->json_players_decoded()),
                    
        ];
        return $this->retornar(true, "",$response);
    }
    public function getMatchs($id){
        
        if(!($tModel=$this->getModel($id))){
            return $this->retornar(false, "El torneo no existe");
        }
        $response[]=[
                    "id_torneo"=> $tModel->get_id_torneo(),
                    "tipoTorneo"=>$tModel->get_tipoTorneo(),
                    "fecha"=> \DateTime::createFromFormat("Y-m-d H:i:s", $tModel->get_fecha())->format("Y-m-d"),
                    "matchs"=> $this->obtener_matchs($tModel->json_matchs_decoded()),
                    
        ];
        return $this->retornar(true, "",$response);
    }
    
    private function getModel($id){
        $tModel = new TorneoModel();
        $tModel->get($id);
        if($tModel->getId()!=$id){
            return null;
        }
        return $tModel;
    }
    
    private function obtener_winner(\stdClass $winner){
        return (array)$winner;
    }
    private function obtener_players(array $players){
        return array_map(function($player){
            return json_decode($player);
        }, $players);
    }
    private function obtener_matchs(array $matchs){
        return array_map(function($match){
            return json_decode($match);
        }, $matchs);
    }
    
    private function registerInTorneo(TorneoHelper $torneo, array $player){
        $torneo->with_player(PlayerFactoryProvider::provide($torneo)
                             ->prepare($player)
                             ->with_suerte($this->getLucky())
                             ->build());              
    }
    
    private function getLucky() {
        return random_int(1,100);
    }
    private function saveResult(TorneoHelper $torneo){
        $torneoModel=new TorneoModel();
        $torneoModel->set_id_usser(self::$USUARIO->getId());
        $torneoModel->set_json_players($torneo->getJsonPlayers());
        $torneoModel->set_json_matchs($torneo->getJsonMatchs());
        $torneoModel->set_winner($torneo->champion->toJson());
        $torneoModel->set_tipoTorneo($torneo->tipoTorneo);
        return $torneoModel->set();
    }
}
