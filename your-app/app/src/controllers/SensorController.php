<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class SensorController extends BaseController
{
  protected $logger;
  protected $SensorModel;
  protected $view;

  public function __construct($logger, $SensorModel, $view)
  {
    $this->logger = $logger;
    $this->SensorModel = $SensorModel;
    $this->view = $view;
  }

    public function sensor_register_request(Request $request, Response $response, $args)
    {
    
      header('Content-type:application/json');
      $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
      $data = json_decode($json, true);
      
      
      $response = array(
        'message' => 'sensor_register_request.',
        'result_code' => 1
      );
      return json_encode($response);

    }
    public function Reset(Request $request, Response $response, $args)
    {
      //SELECT id FROM User Where nonce = 'another nonceaaaaaa';
      //if FOUND, then user is owner , so give user the new password page
        //reset nonce to null
      //if not found, then give User error Message


    }


}
