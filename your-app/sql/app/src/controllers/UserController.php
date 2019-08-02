<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

final class UserController extends BaseController
{
  protected $logger;
  protected $UserModel;
  protected $view;

  public function __construct($logger, $UserModel, $view)
  {
    $this->logger = $logger;
    $this->UserModel = $UserModel;
    $this->view = $view;
  }

  //============================================================================================
  // rending page
  //============================================================================================

  public function sign_up_page(Request $request, Response $response, $args)
  {
    $this->view->render($response, 'signup.twig');
    return $response;
  }

  public function sign_in_page(Request $request, Response $response, $args)
  {
    $this->view->render($response, 'signin.twig');
    return $response;
  }

  public function pw_change_page(Request $request, Response $response, $args)
  {
    $this->view->render($response, 'pwchange.twig');
    return $response;
  }

  public function forgotton_pw_change_page(Request $request, Response $response, $args)
  {
    $this->view->render($response, 'fpwchange.twig');
    return $response;
  }

  public function ID_cancellation_page(Request $request, Response $response, $args)
  {
    $this->view->render($response, 'IDCancellation.twig');
    return $response;
  }

  public function user_index_page(Request $request, Response $response, $args)
  {
    $this->view->render($response, 'user_index.twig');
    return $response;
  }


  //
  // API
  //

  
  //============================================================================================
  //  Sign-up
  //============================================================================================

  public function sign_up_request(Request $request, Response $response, $args)
  {
    try {
      $user['e_mail'] =  $_POST['e_mail'];
      $user['first_name'] =  $_POST['first_name'];
      $user['last_name'] =  $_POST['last_name'];
      $user['birth_date'] =  $_POST['birth_date'];
      $user['timestamp'] =  date("Y-m-d H:i:s");
      $user['hashed_pwd'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
      // Create auth_code by random value and hash function
      $temp =  password_hash(strval(mt_rand()), PASSWORD_DEFAULT);
      $user['auth_code'] = str_replace(array('\\', '/', '.'), strval(mt_rand()), $temp);
      for ($i=0 ; $i <= 6 ; $i++) { 
        $user['auth_code'][$i] =  strval(mt_rand());
    } 
        
      if (strcmp($_POST['password'], $_POST['confirm_password']) !== 0) {
        $this->view->render(
          $response,
          'signup.twig',
          ['error_message' => 'Two password are different', 'result_code' => 1]
        );
        return $response;
      }

      if (count($this->UserModel->duplicate_check_by_email_from_user_table($user)) >= 1) {   //User does exist in "User" table

        $this->view->render(
          $response,
          'signup.twig',
          ['error_message' => 'E-mail address found from table.', 'result_code' => 1]
        );
        return $response;
      } else {  //User doesn't exist in "User" table
        if (count($this->UserModel->duplicate_check_by_email_from_temp_user_table($user)) != 0) {
          //but User does exist in "Temp_user" table

          $this->view->render($response, 'signup.twig', ['error_message' => 'We have already received your sign-up request and authentication-mail has been sent. 
          Please, Check your e-mail again.', 'result_code' => 1]);
          return $response;
        } else {    //User doesn't exist in "User" and "Temp_user" table

          $query_results =  $this->UserModel->insert_user_into_temp_table($user);

          if ($query_results) {
            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
              //Server settings
              $mail->isSMTP();                                      // Set mailer to use SMTP
              $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
              $mail->SMTPAuth = true;                               // Enable SMTP authentication
              $mail->Username = 'dmsrb1595@gmail.com';                 // SMTP username
              $mail->Password = 'znjfzja1!';                           // SMTP password
              $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
              $mail->Port = 587;                                    // TCP port to connect to

              //Recipients
              $auth_url =  'http://teamd-iot.calit2.net/user/signin/activate/' . $user['auth_code'];
              $mail->setFrom('dmsrb1595@gmail.com', 'Team D');
              $mail->addAddress($user['e_mail'], 'Team D');     // Add a recipient
              $mail->isHTML(true);                                  // Set email format to HTML
              $mail->Subject = 'Authentication E-mail from "Fresh Your Route"!!';
              $mail->Body    = 'This is an Authentication E-mail to activate your account.
            <br>If you want to activate your acccount, Please,' . "<a href=\"$auth_url\">
            Click Here !!</a><p>";

              $mail->send();
              return $this->view->render($response, 'signup.twig', ['success_message'
              => 'Authentication-mail has been sent. Please check your E-mail.', 'result_code' => 0]);
            } catch (Exception $e) {
              $this->view->render($response, 'signup.twig', ['error_message'
              => 'Authentication-mail could not be sent. Try again.', 'result_code' => 1]);
              return $response;
            }
          } // if insert query is true
          else {
            $this->view->render($response, 'signup.twig', ['error_message'
            => 'Inserting the User Information into table is failed. Try again.', 'result_code' => 1]);
            return $response;
          }
        }
      }
    } catch (PDOException $e) {

      $this->view->render($response, 'signup.twig', ['error_message'
      => 'PDOException. Try again.', 'result_code' => 1]);
      return $response;
    }
  }


  public function account_activate(Request $request, Response $response, $args)
  {
    try {
      $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      $parts = parse_url($url);

      $nonce = substr($parts['path'], 22);

      $user_data = $this->UserModel->select_user_information_by_nonce_from_temp_table($nonce);

      if (count($user_data) == 1) {
        $user_data[0]['permission'] = 0;
        $user_data[0]['loginStateFlag'] = 0;
        $user_data[0]['isActive'] = 1;
        $user_data[0]['auth_code'] = NULL;
        //  if nonce doese exist in temp table,
        if ($this->UserModel->insert_user_into_user_table($user_data[0])) {
          if ($this->UserModel->delete_from_temp_user_table($nonce) == 0) {

            $this->view->render($response, 'signin.twig', ['success_message'
            => 'Your account is activated.', 'result_code' => 0]);
            return $response;
          } else {
            $this->view->render($response, 'signin.twig', ['error_message'
            => 'Your account is unactivated', 'result_code' => 1]);
            return $response;
          }
        } else {
          $this->view->render($response, 'signin.twig', ['error_message'
          => 'Your account is unactivated.', 'result_code' => 1]);
          return $response;
        }
      } else {
        $this->view->render($response, 'signin.twig', ['error_message'
        => 'Your account is unactivated', 'result_code' => 1]);
        return $response;
      }
    } catch (PDOException $e) {
      $this->view->render($response, 'signin.twig', ['error_message'
      => 'Exception occurred', 'result_code' => 1]);
      return $response;
    }
  }

  //============================================================================================
  //  Sign-in
  //============================================================================================


  public function sign_in_request(Request $request, Response $response, $args)
  {
    $json = [];
    $user = [];
    try {
   
      if (isset($_POST['e_mail']) || isset($_POST['password'])) {
        $user['e_mail'] =  $_POST['e_mail'];
        $user['password'] =  $_POST['password'];
      } else {
        $json = ['error_message' => 'No e_mail or pssword', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      $results = $this->UserModel->select_USN_PW_from_User_table($user);

      if ($results) {

        if (password_verify($user['password'], $results['hashed_pwd'])) {
          $user['USN'] = $results['USN'];
          $results['loginStateFlag'] = 1;

          if ($this->UserModel->update_user_set_loginStateFlag($results) == 0) {
            $user['permission'] = $this->UserModel->select_permission_from_user_table($results);

            $json = [
              'success_message' => 'Sign-In is completed', 'USN' => $user['USN'], 'permission' => $user['permission'], 'result_code' => 0
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          } else {

            $json = ['error_message' => 'Sign-In is Failed', 'result_code' => 1];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          }
        } else {
          $json = ['error_message' => 'Sign-In is Failed, Password is wrong', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
      } else {

        $json = ['error_message' => 'E-mail is not found in table, Please sign-up first', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    } //end of try

    catch (PDOException $e) {
      $json = ['error_message' => 'exception occurred', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($json));
    }
  }


  //============================================================================================
  //  Sign-out
  //============================================================================================

  public function sign_out_request(Request $request, Response $response, $args)
  {
    try {
      if (isset($_POST['USN'])) {

        $user['USN'] =  $_POST['USN'];
      } else {
        $json = ['error_message' => 'No USN', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      if ($this->UserModel->update_user_set_loginStateFlag($user) == 0) {
        $user['loginStateFlag'] = 0;
        $json = ['success_message' => 'You have been logged out.', 'result_code' => 0];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      } else {
        $json = ['error_message' => 'log-out is failed ', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    } catch (PDOException $e) {
      $json = ['error_message' => 'exception occurred', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($json));
    }
  }


  //============================================================================================
  //  ID Cancellation
  //============================================================================================

  public function ID_cancellation_request(Request $request, Response $response, $args)
  {
    $json = [];
    $user = [];
    try {

      if (isset($_POST['USN']) && isset($_POST['password'])) {
        $user['password'] =  $_POST['password'];
        $user['USN'] =  $_POST['USN'];
      } else {
        $json = ['error_message' => 'No USN or pssword', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      $results = $this->UserModel->select_hashpw_from_user_table($user);

      if ($results) {

        if (password_verify($user['password'], $results['hashed_pwd'])) {
          $user['isActive'] = 0;


          if ($this->UserModel->update_user_set_isActive($user) == 0) {

            $json = [
              'success_message' => 'ID cancellation is completed', 'result_code' => 0
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          } else {

            $json = [
              'error_message' => 'ID cancellation is Failed . Please, Try again', 'result_code' => 1
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          }
        } else {
          $json = [
            'error_message' => 'ID cancellation is Failed . Please, Try again', 'result_code' => 1
          ];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
      } else {

        $json = [
          'error_message' => 'ID cancellation is Failed . Please, Try again', 'result_code' => 1
        ];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    } catch (PDOException $e) {
      $json = ['error_message' => 'exception occurred', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($json));
    }
  }
  //============================================================================================
  //  Password Change
  //============================================================================================


  public function pw_change_request(Request $request, Response $response, $args)
  {
    $json = [];
    $user = [];
    try {
      if (
        isset($_POST['USN']) && isset($_POST['password']) &&
        isset($_POST['new_password']) && isset($_POST['confirm_new_password'])
        && ($_POST['new_password'] === $_POST['confirm_new_password'])
      ) {
        $user['password'] =  $_POST['password'];
        $user['USN'] =  $_POST['USN'];
      } else {
        $json = ['error_message' => 'Can not get the user\'s information from the client', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      $results = $this->UserModel->select_hashpw_from_user_table($user);

      if ($results) {

        if (password_verify($user['password'], $results['hashed_pwd'])) {
          $user['new_password'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

          if ($this->UserModel->update_user_set_password($user) == 0) {

            $json = [
              'success_message' => 'Password change completed', 'result_code' => 0
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          } else {

            $json = [
              'error_message' => 'Password change failed. Please, Try again', 'result_code' => 1
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          }
        } else {
          $json = [
            'error_message' => 'Password is wrong. Please, Try again', 'result_code' => 1
          ];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
      } else {

        $json = [
          'error_message' => 'Password change failed. Please, Try again', 'result_code' => 1
        ];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    } catch (PDOException $e) {
      $json = ['error_message' => 'exception occurred', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($json));
    }
  }
  //============================================================================================
  //  Forgotten password Change
  //============================================================================================

  
  public function forgotton_pw_change_request(Request $request, Response $response, $args)
  {
    $json = [];
    $user = [];
    try {

      if (isset($_POST['e_mail'])) {
        $user['e_mail'] =  $_POST['e_mail'];
      } else {
        $json = ['error_message' => 'No E-mail', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      $results = $this->UserModel->duplicate_check_by_email_from_user_table($user);
      if (count($results) == 1) {
        $user['USN'] = $results[0]['USN'];
        $temp =  password_hash(strval(mt_rand()), PASSWORD_DEFAULT);
        $user['auth_code'] = str_replace(array('\\', '/', '.'), strval(mt_rand()), $temp);
      for ($i=0 ; $i <= 6 ; $i++) { 
        $user['auth_code'][$i] =  strval(mt_rand());
    } 
  
        if ($this->UserModel->update_user_set_auth_code($user) == 0) {

          $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
          try {
            // Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'dmsrb1595@gmail.com';                 // SMTP username
            $mail->Password = 'znjfzja1!';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $auth_url =  'http://teamd-iot.calit2.net/account/resetpasswd/' . $user['auth_code'];
            $mail->setFrom('dmsrb1595@gmail.com', 'Team D');
            $mail->addAddress($user['e_mail'], 'Team D');     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Authentication E-mail from "Fresh Your Route"!!';
            $mail->Body    = 'I’m sorry that you lost your password.
            <br>If you want to reset your acccount password, Please,' . "<a href=\"$auth_url\">
            Click Here </a><p>";

            $mail->send();
            $this->view->render($response, 'signin.twig', ['success_message'
            => 'Authentication-mail has been sent. Please check your E-mail.', 'result_code' => 0]);
            return $response;
 
          } catch (Exception $e) {

            $json = [
              'error_message' => 'Authentication-mail could not be sent. Try again.', 'result_code' => 1
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          } // end of catch statement 
        } else {

          $json = [
            'error_message' => 'Forgotten Password change failed. Please, Try again', 'result_code' => 1
          ];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
      } else {
        $json = [
          'error_message' => 'Forgotten Password change failed. Please, Try again', 'result_code' => 1
        ];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    } catch (PDOException $e) {
      $json = ['error_message' => 'exception occurred', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($json));
    }
  }

  public function account_resetpasswd(Request $request, Response $response, $args)
  {
    $json = [];
    $user = [];

    try {
      $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      $parts = parse_url($url);

      $nonce = substr($parts['path'], 21);

      $results =$this->UserModel->select_USN_by_nonce_from_user_table($nonce); 
      if(count($results)==1){
        $this->view->render($response, 'fpwenter.twig', ['auth_code'
        => $nonce,'USN'=>$results[0]['USN'], 'result_code' => 0]);
        return $response;
      }

      $json = ['error_message' => 'Error, Can not found USER information ', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($results));

    } catch (PDOException $e) {
      $json = ['error_message' => 'exception occurred', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($results));
    }
  }

  public function account_resetpasswd2(Request $request, Response $response, $args)
  {
    $json =[];
    $user = [];

    try {
      if (isset($_POST['new_password']) || isset($_POST['confirm_new_password'])) {
        $user['new_password'] =  $_POST['new_password'];
        $user['confirm_new_password'] =  $_POST['confirm_new_password'];
      } else {
        $json = ['error_message' => 'No new_password or confirm_new_password', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
      
      $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      $parts = parse_url($url);

      $nonce = substr($parts['path'], 22);

      $results =$this->UserModel->select_USN_by_nonce_from_user_table($nonce); 
      if(count($results)==1){
        $user['USN']= $results[0]['USN'];
        $user['hashed_pwd'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $user['auth_code'] =  NULL;

      if($this->UserModel->update_user_set_password_auth_code($user)){
        $json = ['success_message' => 'Forgotten password change is completed. ', 'result_code' => 0];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($results));
      }
        else{
          $json = ['error_message' => 'Error, Can not found USER information ', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($results));
        }     
      }
      else{
        $json = ['error_message' => 'Error, Can not found USER information  ', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($results));
      }

    } catch (PDOException $e) {
      $json = ['error_message' => 'exception occurred', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($results));
    }
  }

  public function json_test(Request $request, Response $response, $args)
  {
    $json = [];
    $user = [];
    $user['e_mail'] =  $_POST['e_mail'];
    $user['password'] = $_POST['password'];

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    echo $data->e_mail;
  }
} // end of UserController
