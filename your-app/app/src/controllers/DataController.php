<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Doctrine\DBAL\Driver\PDOException;

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
//============================================================================================================================
// Real-time Data
//============================================================================================================================
    public function app_select_realtime_data_from_airquality_table(Request $request, Response $response, $args)
    {
      header('Content-type:application/json');
      $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
      $data = json_decode($json, true);

      try{
        if (isset($data['value'])||isset($data['north'])||isset($data['east'])
        ||isset($data['south'])||isset($data['west'])) {
          $user['value'] =  $data['value'];
          $user['north'] =  $data['north'];
          $user['east'] =  $data['east'];
          $user['south'] =  $data['south'];
          $user['west'] =  $data['west'];
        } else {
          $json = ['error_message' => 'There is no value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } 
        $user['realtime_interval'] =  5;
        $results = $this->DataModel->select_realtime_data_from_airquality_table($user);

        if(count($results)>0){
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($results));
        }else{
          $json = ['error_message' => 'There is no Real-time air quality data', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
     

      }catch(PDOException $e){
        $json = ['error_message' => 'Some errors occurred during getting air quality', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    }

    public function select_realtime_data_from_airquality_table(Request $request, Response $response, $args)
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
        $user['realtime_interval'] =  1;
        $results = $this->DataModel->select_realtime_data_from_airquality_table($user);

        if(count($results)>0){
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($results));
        }else{
          $json = ['error_message' => 'There is no Real-time air quality data', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
     

      }catch(PDOException $e){
        $json = ['error_message' => 'Some errors occurred during getting air quality', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    }



     
    public function select_realtime_data_from_heartrate_table(Request $request, Response $response, $args)
    {

      try{
        if (isset($_POST['USN'])) {
          $user['USN'] =  $_POST['USN'];

        } else {
          $json = ['error_message' => 'There is no value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } 
       
         $results = $this->DataModel->select_realtime_data_from_heartrate_table($user);

        if(count($results)>0){
          return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($results));
        }else{
          $json = ['error_message' => 'There is Heart-rate data', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
     

      }catch(PDOException $e){
        $json = ['error_message' => 'Some errors occurred during getting  Real-time heart-rate data', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    }

//============================================================================================================================
// Historical Data
//============================================================================================================================
    public function select_historical_data_from_airquality_table(Request $request, Response $response, $args)
    {
      
      try{
        if (isset($_POST['SSN'])||isset($_POST['historical_interval'])) {
          $user['SSN'] =  $_POST['SSN'];
          $user['historical_interval'] =  $_POST['historical_interval'];
        } else {
          $json = ['error_message' => 'There is no value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } 

        $results = $this->DataModel->select_historical_data_from_airquality_table($user);


          if(count($results)>0){

            foreach (array("s1"=>'CO', "s2"=>'NO2', "s3"=>'O3', "s4"=>'SO2', "s5"=>'PM2_5', "s6"=>'temperature') as $sensor=>$sensor_label) {
              // build array for Column labels
              $json_array['cols'] = array(
                      array('id'=>'', 'label'=>'date/time', 'type'=>'string'),
                      array('id'=>'', 'label'=>$sensor_label, 'type'=>'number'));

              // loop thru the sensor data and build sensor_array
              foreach ($results as $row) {
                  $sensor_array = array();
                  $sensor_array[] = array('v'=>$row['air_timestamp']);
                  $sensor_array[] = array('v'=>$row[$sensor_label]);
              
                  // add current sensor_array line to $rows
                  $rows[] = array('c'=>$sensor_array);
              }
          
              // add $rows to $json_array
              $json_array['rows'] = $rows;
              $rows = array();
          
              $master_array[$sensor][] = $json_array;
         }
        
      return $response->withHeader('Content-type', 'application/json')
      ->write(json_encode($master_array, JSON_NUMERIC_CHECK))
      ->withStatus(200);
        }

        else{
          $json = ['error_message' => 'There is no histrocial air quality value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
        

      }catch(PDOException $e){
        $json = ['error_message' => 'Some errors occurred during getting  Historical airquality data', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    }

    public function app_select_historical_data_from_airquality_table(Request $request, Response $response, $args)
    {
      header('Content-type:application/json');
      $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
      $data = json_decode($json, true);

      try{
        if (isset($data['SSN'])||isset($data['historical_interval'])) {
          $user['SSN'] =  $data['SSN'];
          $user['historical_interval'] =  $data['historical_interval'];
        } else {
          $json = ['error_message' => 'There is no value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } 

        $results = $this->DataModel->select_historical_data_from_airquality_table($user);

          if(count($results)>0){

          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($results));
        }

        else{
          $json = ['error_message' => 'There is no histrocial air quality value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
        

      }catch(PDOException $e){
        $json = ['error_message' => 'Some errors occurred during getting  Historical airquality data', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    }

      public function select_historical_heartrate_data_from_heartrate_table(Request $request, Response $response, $args)
    {
      try{
        if (isset($_POST['USN'])||isset($_POST['historical_interval'])) {
          $user['USN'] =  $_POST['USN'];
          $user['historical_interval'] =  $_POST['historical_interval'];
        } else {
          $json = ['error_message' => 'There is no value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } 

        $results = $this->DataModel->select_historical_heartrate_data_from_heartrate_table($user);
        if(count($results)>0){

          foreach (array("s1"=>'heart_rate') as $sensor=>$sensor_label) {
            // build array for Column labels
            $json_array['cols'] = array(
                    array('id'=>'', 'label'=>'date/time', 'type'=>'string'),
                    array('id'=>'', 'label'=>$sensor_label, 'type'=>'number'));

            // loop thru the sensor data and build sensor_array
            foreach ($results as $row) {
                $sensor_array = array();
                $sensor_array[] = array('v'=>$row['heart_timestamp']);
                $sensor_array[] = array('v'=>$row[$sensor_label]);
            
                // add current sensor_array line to $rows
                $rows[] = array('c'=>$sensor_array);
            }
        
            // add $rows to $json_array
            $json_array['rows'] = $rows;
            $rows = array();
        
            $master_array[$sensor][] = $json_array;
        }
        
      return $response->withHeader('Content-type', 'application/json')
      ->write(json_encode($master_array, JSON_NUMERIC_CHECK))
      ->withStatus(200);
        }
        else{
          $json = ['error_message' => 'There is no histrocial heart rate value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
        

      }catch(PDOException $e){
        $json = ['error_message' => 'Some errors occurred during getting  Historical heart-rate data', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    }
    public function marker_select_historical_data_from_airquality_table(Request $request, Response $response, $args)
    {
      try{
        if (isset($_POST['SSN'])||isset($_POST['historical_interval'])) {
          $user['SSN'] =  $_POST['SSN'];
          $user['historical_interval'] =  $_POST['historical_interval'];
        } else {
          $json = ['error_message' => 'There is no value.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } 

        $results = $this->DataModel->select_historical_data_from_airquality_table($user);
    
          if(count($results)>0){
            return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($results));
          }
          else{
            $json = ['error_message' => 'There is no value.', 'result_code' => 1];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          }


      }catch(PDOException $e){
        $json = ['error_message' => 'Some errors occurred during getting  Historical airquality  data', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    }
    
        
}
