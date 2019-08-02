<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class DataController extends BaseController
{
protected $logger;
  protected $DataModel;
  protected $view;

  public function __construct($logger, $DataModel, $view)
  {
    $this->logger = $logger;
    $this->DataModel = $DataModel;
    $this->view = $view;
  }

public function data_transfer_request(Request $request, Response $response, $args)
    {
      header('Content-type:application/json');
      $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
      $data = json_decode($json, true);
    //   $response = array(
    //     'success_message' => 'Airquality is stored.',
    //     'result_code' => 0,
    //   );
    //   return json_encode($data['O3']);
      $response = array(
        'SSN' => $data['SSN'],
        'timestamp' => $data['timestampl'],
        'temperature' => $data['temperature'],
        'PM2.5' => $data['PM2.5'],
        'CO' => $data['CO'],
        'NO2' => $data['NO2'],
        'O3' => $data['O3'],
        'SO2' => $data['SO2'],
        'PM2.5_AQI' => $data['PM2.5_AQI'],
        'CO_AQI' => $data['CO_AQI'],
        'NO2_AQI' => $data['NO2_AQI'],
        'O3_AQI' => $data['O3_AQI'],
        'SO2_AQI' => $data['SO2_AQI'],
        'lat' => $data['lat'],
        'lng' => $data['lng'],
      );
      if($this->DataModel->insert_data_into_airquaility_table($data)){
        $response = array(
            'success_message' => 'Airquality is stored.',
            'result_code' => 0,
          );
          return json_encode($response);
      } else{
        $response = array(
            'success_message' => 'Airquiality is not stored.',
            'result_code' => 1,
          );
          return json_encode($response);
      }
    }
}
