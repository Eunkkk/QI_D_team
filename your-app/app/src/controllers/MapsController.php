<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class MapsController extends BaseController
{

    protected $logger;
    protected $userModel;
    protected $view;
    
    public function __construct($view, $logger, $mapsModel)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->maps = $mapsModel;
    }
    
    // simple example of markers    
    public function defaulta(Request $request, Response $response, $args) {
        $response = $this->view->render($response, 'maps/hotelmarkers.phtml');
        return $response;        
   } 

    // simple example of circles instead of markers
    public function circles(Request $request, Response $response, $args) {
        $response = $this->view->render($response, 'maps/example-map.phtml');
        return $response;        
   } 

    public function fakesensors(Request $request, Response $response, $args) {
        $response = $this->view->render($response, 'maps/pokemon-map.phtml');
        return $response; 
    }

    public function fakesensors_as_json(Request $request, Response $response, $args) {
        try {
            $mapdata = $this->maps->getFakeSensorByFeedsId(3); //아이디로 db 에서 값을 가져옴

            if ($mapdata) {     //값 존재하면 
                $person_array = [];
                foreach ($mapdata as $person) { //값을 person 으로 넣고 어레이 생성 
                    $person_array[] = 
              array("id"=>$person['id'], 
                    "name"=>$person['name'], 
                    "dex"=>$person['pokedex'], 
                    "center" => array("lat" => $person['lat'], "lng" => $person['lng']),
                    "population" => "2000",
                    "s1"=>$person['s1'],
                    "s2"=>$person['s2'],
                    "s3"=>$person['s3'],
                    "s4"=>$person['s4'],
                    "s5"=>$person['s5'],
                    "s6"=>$person['s6'],
                    );
            }

                return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($person_array, JSON_NUMERIC_CHECK));    //어레이로 보냄 

            } else {
                $response = $response->withStatus(404);
            }
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
   } 

    public function pokemon(Request $request, Response $response, $args) {
        $response = $this->view->render($response, 'pokemap.phtml');
        return $response;
    }    

}
