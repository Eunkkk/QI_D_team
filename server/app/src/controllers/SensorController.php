<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class SensorController extends BaseController
{


    public function Activate(Request $request, Response $response, $args)
    {



    }
    public function Reset(Request $request, Response $response, $args)
    {
      //SELECT id FROM User Where nonce = 'another nonceaaaaaa';
      //if FOUND, then user is owner , so give user the new password page
        //reset nonce to null
      //if not found, then give User error Message


    }


}
