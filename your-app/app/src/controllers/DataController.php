<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class DataController extends BaseController
{
  protected $logger;
  protected $DataModel;
  protected $view;

 
  public function __construct($view, $DataModel, $logger)
  {
    $this->logger = $logger;
    $this->DataModel = $DataModel;
    $this->view = $view;
  }

public function data_heartrate_page(Request $request, Response $response,$args){
  $this->view->render($response, 'heartrate.twig');
  return $response;
}

public function data_airquality_page(Request $request, Response $response,$args){
  $this->view->render($response, 'airquality.twig');
  return $response;
}


  //app to database 
public function data_airquality_transfer_request(Request $request, Response $response, $args)
    {
      header('Content-type:application/json');
      $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
      $data = json_decode($json, true);
      try{
        
      $result = $this->DataModel->select_SSN_from_sensor_info_table($data);

      if(count($result)!=0){
        if(($this->DataModel->insert_data_into_airquaility_table($data))>0){
          $response = array(
              'success_message' => 'Airquality data is stored.',
              'result_code' => 0,
            );
            return json_encode($response);
        } else{
          $response = array(
              'error_message' => 'Airquiality data is not stored.',
              'result_code' => 1,
            );
            return json_encode($response);
        }
      }else{
        $response = array(
          'error_message' => 'You have to Sensor registration first .',
          'result_code' => 1,
        );
        return json_encode($response);
      }

       }catch(PDOException $e){
        $response = array(
          'error_message' => 'Some errors occurred during airquality data transfer.',
          'result_code' => 1,
        );
      }
    }

    public function data_heartrate_transfer_request(Request $request, Response $response, $args)
    {
      header('Content-type:application/json');
      $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
      $data = json_decode($json, true);
      

      try{
        
        if(($this->DataModel->insert_data_into_heartrate_table($data))>0){
          $response = array(
              'success_message' => 'Heart rate data is stored.',
              'result_code' => 0,
            );
            return json_encode($response);
        } else{
          $response = array(
              'error_message' => 'Heart rate data is not stored.',
              'result_code' => 1,
            );
            return json_encode($response);
        }
   

       }catch(PDOException $e){
        $response = array(
          'error_message' => 'Some errors occurred during heart_rate data transfer.',
          'result_code' => 1,
        );
        return json_encode($response);
      }
    }

    public function get_airquality_request(Request $request, Response $response, $args)
    {

      try{
        if (isset($_POST['value'])||isset($_POST['north'])||isset($_POST['east'])
        ||isset($_POST['south'])||isset($_POST['west'])) {
          $user['value'] =  $_POST['value'];
          $user['north'] =  $_POST['north'];
          $user['east'] =  $_POST['east'];
          $user['south'] =  $_POST['south'];
          $user['west'] =  $_POST['west'];
        } else {
          $json = ['error_message' => 'There is no value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } 
       
        $results = $this->DataModel->select_data_from_airquality_table($user);

        if(count($results)>0){
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($results));
        }else{
          $json = ['error_message' => 'There is no air quality data', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
     

      }catch(PDOException $e){
        $json = ['error_message' => 'Some errors occurred during getting air quality', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    }

     
    public function get_heartrate_request(Request $request, Response $response, $args)
    {

      try{
        if (isset($_POST['USN'])) {
          $user['USN'] =  $_POST['USN'];

        } else {
          $json = ['error_message' => 'There is no value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } 
       
         $results = $this->DataModel->select_data_from_heartrate_table($user);

        if(count($results)>0){
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($results));
        }else{
          $json = ['error_message' => 'There is Heart-rate data', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
     

      }catch(PDOException $e){
        $json = ['error_message' => 'Some errors occurred during getting  Heart-rate data', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    }
    

    

}
