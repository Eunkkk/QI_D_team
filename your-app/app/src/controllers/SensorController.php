<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Doctrine\DBAL\Driver\PDOException;

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
  
  //============================================================================================
  //  page rendering
  //============================================================================================

  public function sensor_userlist_view_page(Request $request, Response $response, $args)
  {
    $this->view->render($response, 'sensorlistview.twig');
    return $response;
  }


    public function sensor_registraion_request(Request $request, Response $response, $args)
    {
    
      header('Content-type:application/json');
      $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
      $data = json_decode($json, true);
      
  
      try{
        if (isset($data['USN'])||isset($data['MAC_address'])
        ||isset($data['timestamp'])||isset($data['timestamp'])) {
          $user['USN'] =  $data['USN'];
          $user['MAC_address'] =  $data['MAC_address'];
          $user['sensor_name'] =  $data['sensor_name'];
          $user['timestamp'] =  $data['timestamp'];
        } else {
          $json = ['error_message' => 'Please, Sign-in first.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } 

        $results = $this->SensorModel->select_sensor_info_by_USN_AND_MAC($user);
        if(count($results)==1){
          $json = ['error_message' => 'Already registered MAC_address', 'result_code' => 1
        ,'SSN'=>$results[0]['SSN']];

        }else{
          $results2 = $this->SensorModel->select_USN_by_MAC($user);
          if(count($results2)==0){
              $user['regActive'] = 1;
              if($this->SensorModel->insert_sensor_info_into_sensor_info_table($user)>0){
                if(count($this->SensorModel->select_SSN_by_MAC($user))>0){
                  $json = ['success_message' => 'Sensor registration is completed.', 'result_code' => 0];
                }else{
                  $json = ['error_message' => 'Some errors occurred during Sensor registration.', 'result_code' => 1];
                }
              }
              else{
                $json = ['error_message' => 'Some errors occurred during Sensor registration.', 'result_code' => 1];
              }
          }
          else{
          $json = ['error_message' => 'Some errors occurred during Sensor registration.', 'result_code' => 1];
          }
        }
        return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($json));
      }
      catch(PDOException $e)     
       {
        $json = ['error_message' => 'Some errors occurred during Sensor registration.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json)); 
      }


    }
    public function sensor_deregistration_request(Request $request, Response $response, $args)
    {
      try{
        if (isset($_POST['USN'])) {
          $user['USN'] =  $_POST['USN'];
          $user['SSN'] =  $_POST['SSN'];
          $user['regActive'] = 0;
        } else {
          $json = ['error_message' => 'Please, Sign-in first.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }  
        $results = $this->SensorModel->update_sensor_info_set_regAtive($user);

        if (($results)>0){

          $json = ['success_message' => 'Sensor deregistration is completed.',
           'result_code' => 0];
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
        }else{
          $json = ['error_message' => 'Sensor deregistration is failed',
           'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
        }     
      }
      catch(Exception $e )
      {
        $json = ['error_message' => 'Some errors occurred during Sensor deregistration.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json)); 
      }
    }

    public function sensor_userlist_view_request(Request $request, Response $response, $args)
    {
      try{
        if (isset($_POST['USN'])) { 
          $user['USN'] =  $_POST['USN'];
        } else {
          $json = ['error_message' => 'Please, Sign-in first.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }

        $results = $this->SensorModel->select_sensor_info_from_User_table($user);

        if (count($results)==0){

          $json = ['error_message' => 'There is no sensor inforamtion ', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
        }else{
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($results));
        }     
      }
      catch(Exception $e )
      {
        $json = ['error_message' => 'Some errors occurred during Sensor list view.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json)); 
      }
    }

    
    public function app_sensor_userlist_view_request(Request $request, Response $response, $args)
    {
      $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
      $data = json_decode($json, true);
      try{
        if (isset($data['USN'])) {
          $user['USN'] =  $data['USN'];
        } else {
          $json = ['error_message' => 'Please, Sign-in first.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }

        $results = $this->SensorModel->select_sensor_info_from_User_table($user);

        if (count($results)==0){

          $json = ['error_message' => 'There is no sensor inforamtion ', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
        }else{
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($results));
        }     
      }
      catch(Exception $e)
      {
        $json = ['error_message' => 'Some errors occurred during Sensor list view.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json)); 
      }
    }

    public function app_sensor_deregistration_request(Request $request, Response $response, $args)
    {
      $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
      $data = json_decode($json, true);
      try{
        if (isset($data['USN'])) {
          $user['USN'] =  $data['USN'];
          $user['SSN'] =  $data['SSN'];
          $user['regActive'] = 0;
        } else {
          $json = ['error_message' => 'Please, Sign-in first.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }  
        $results = $this->SensorModel->update_sensor_info_set_regAtive($user);

        if (($results)>0){

          $json = ['success_message' => 'Sensor deregistration is completed.',
           'result_code' => 0];
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
        }else{
          $json = ['error_message' => 'Sensor deregistration is failed',
           'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
        }     
      }
      catch(Exception $e )
      {
        $json = ['error_message' => 'Some errors occurred during Sensor deregistration.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json)); 
      }
    }






}
