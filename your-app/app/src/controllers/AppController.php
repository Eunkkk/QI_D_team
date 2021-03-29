<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


final class AppController extends BaseController
{

  protected $logger;
  protected $AppMdoel;
  protected $UserModel;
  protected $view;

  public function __construct($logger, $AppMdoel, $view, $UserModel)
  {
    $this->logger = $logger;
    $this->AppMdoel = $AppMdoel;
    $this->view = $view;
    $this->UserModel = $UserModel;
  }


  public function app_signin_up_request(Request $request, Response $response, $args)
  {
    header('Content-type:application/json');
    $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
    $data = json_decode($json, true);

    $user = [];
    try {
      if (
        isset($data['e_mail']) || isset($data['password']) || isset($data['password'])
        || isset($data['confirm_password']) || isset($data['first_name']) || isset($data['last_name'])
        || isset($data['password']) || isset($data['password']) || isset($data['password'])
        || isset($data['birth_date'])
      ) {

        $user['e_mail'] =  $data['e_mail'];
        $user['first_name'] =  $data['first_name'];
        $user['last_name'] =  $data['last_name'];
        $user['birth_date'] =  $data['birth_date'];
        $user['timestamp'] =  date("Y-m-d H:i:s");
        $user['hashed_pwd'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $temp =  password_hash(strval(mt_rand()), PASSWORD_DEFAULT);   // Create auth_code by random value and hash function
        $user['auth_code'] = str_replace(array('\\', '/', '.'), strval(mt_rand()), $temp);
        for ($i = 0; $i <= 6; $i++) {
          $user['auth_code'][$i] =  strval(mt_rand());
        }
      } else {
        $response = array(
          'error_message' => 'No information received.',
          'result_code' => 1
        );
        return json_encode($response);
      }

      if (strcmp($user['password'], $user['confirm_password']) !== 0) { //if The passwords do not match.

        $response = array(
          'error_message' => 'There is no e_mail or pssword.',
          'result_code' => 1
        );
        return json_encode($response);
      }

      if (count($this->UserModel->duplicate_check_by_email_from_user_table($user)) >= 1) {   //User does exist in "User" table

        $response = array(
          'error_message' => 'This E-mail has already been signed up.',
          'result_code' => 1
        );
        return json_encode($response);
      } else {  //User doesn't exist in "User" table
        if (count($this->UserModel->duplicate_check_by_email_from_temp_user_table($user)) != 0) {
          //but User does exist in "Temp_user" table

          $response = array(
            'error_message' => 'We have already received your sign-up request and authentication-mail has been sent. 
          // Please, Check your E-mail again.',
            'result_code' => 1
          );
          return json_encode($response);
        } else {    //User doesn't exist in "User" and "Temp_user" table

          $query_results =  $this->UserModel->insert_user_into_temp_table($user);

          if ($query_results) { // if insert query is successful
            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
              //Server settings
              $mail->isSMTP();                                      // Set mailer to use SMTP
              $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
              $mail->SMTPAuth = true;                               // Enable SMTP authentication
              $mail->Username = 'dmsrb1595@gmail.com';                 // SMTP username
              $mail->Password = 'P@ssw0rd123!@';                           // SMTP password
              $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
              $mail->Port = 587;                                    // TCP port to connect to

              //Recipients
              $auth_url =  'http://localhost:8888/user/signin/activate/' . $user['auth_code'];
              $mail->setFrom('dmsrb1595@gmail.com', 'Team D');
              $mail->addAddress($user['e_mail'], 'Team D');          // Add a recipient
              $mail->isHTML(true);                                  // Set email format to HTML
              $mail->Subject = 'Authentication E-mail from "Fresh Your Route"!!';
              $mail->Body    = 'This is an Authentication E-mail to activate your account.
            <br>If you want to activate your acccount, Please,' . "<a href=\"$auth_url\">
            Click Here !!</a><p>";

              $mail->send();

              $response = array(
                'success_message' => 'Authentication-mail has been sent. Please, check your E-mail.',
                'result_code' => 0
              );
              return json_encode($response);
            } catch (Exception $e) {

              $response = array(
                'error_message' => 'Authentication-mail could not be sent. Try again.',
                'result_code' => 1
              );
              return json_encode($response);
            }
          } else {  //else 
            $response = array(
              'error_message' => 'Some errors occurred during sign-up.',
              'result_code' => 1
            );
            return json_encode($response);
          }
        }
      }
    } catch (PDOException $e) {
      $response = array(
        'error_message' => 'Some errors occurred during sign-up.',
        'result_code' => 1
      );
      return json_encode($response);

      // $json = ['error_message' => 'Some errors occurred during sign-up.', 'result_code' => 1];
      // return $response->withHeader('Content-type', 'application/json')
      //   ->write(json_encode($json));
    }
  }

  //============================================================================================
  //  Sign-in
  //============================================================================================

  public function app_signin_in_request(Request $request, Response $response, $args)
  {
    header('Content-type:application/json');
    $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
    $data = json_decode($json, true);

    $json = [];
    $user = [];
    try {

      if (isset($data['e_mail']) || isset($data['password'])) {
        $user['e_mail'] =  $data['e_mail'];
        $user['password'] =  $data['password'];
      } else {

        $response = array(
          'error_message' => 'There is no e_mail or pssword.',
          'result_code' => 1
        );
        return json_encode($response);
      }

      $results = $this->UserModel->select_USN_PW_from_User_table($user); // select USN and hashed_pwd from User table 

      if ($results) {

        if (password_verify($user['password'], $results['hashed_pwd'])) {
          $user['USN'] = $results['USN'];
          $results['loginStateFlag'] = 1; //set login state flage to 1
          $results['isActive'] = 1; //set login state flage to 1

          if ($this->UserModel->update_user_set_loginStateFlag($results) >= 0) {
            $user['permission'] = $this->UserModel->select_permission_from_user_table($results);

            $response = array(
              'success_message' => 'Sign-In is completed.',
              'USN' => $user['USN'],
              'permission' => $user['permission'],
              'result_code' => 0
            );
            return json_encode($response);
          } else {

            $response = array(
              'error_message' => 'Some errors occurred during sign-in.',
              'result_code' => 1
            );
            return json_encode($response);
          }
        } else {
          $response = array(
            'error_message' => 'Sign-In is Failed, Password is wrong.',
            'result_code' => 1
          );
          return json_encode($response);
        }
      } else {

        $response = array(
          'error_message' => 'E-mail does not exist, Please, sign-up first.',
          'result_code' => 1
        );
        return json_encode($response);
      }
    } catch (PDOException $e) {
      $response = array(
        'error_message' => 'Some errors occurred during sign-in.',
        'result_code' => 1
      );
      return json_encode($response);
    }
  }

  public function app_signin_out_request(Request $request, Response $response, $args)
  {
    header('Content-type:application/json');
    $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
    $data = json_decode($json, true);
    //   echo $data->USN;

    try {
      if (isset($data['USN'])) {

        $user['USN'] =  $data['USN'];
        $user['loginStateFlag'] = 0; // set login state flag to 0 
      } else {

        $response = array(
          'error_message' => 'Please, Sign-in first.',
          'result_code' => 1
        );
        return json_encode($response);
      }

      if ($this->UserModel->update_user_set_loginStateFlag($user) >= 0) {

        $response = array(
          'error_message' => 'You have been logged-out.',
          'result_code' => 0
        );
        return json_encode($response);
      } else {
        $response = array(
          'error_message' => 'Some errors occurred during sign-out.',
          'result_code' => 1
        );
        return json_encode($response);
      }
    } catch (PDOException $e) {
      $response = array(
        'error_message' => 'Some errors occurred during sign-out',
        'result_code' => 1
      );
      return json_encode($response);
    }
  }
  
  //============================================================================================
  //  Password Change
  //============================================================================================

  public function app_pw_change_request(Request $request, Response $response, $args)
  {
    $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
    $data = json_decode($json, true);
 
    $json = [];
    $user = [];
    try {
      if (
        isset($data['USN']) && isset($data['password']) &&
        isset($data['new_password']) && isset($data['confirm_new_password'])
        && ($data['new_password'] === $data['confirm_new_password'])
      ) {
        $user['password'] =  $data['password'];
        $user['USN'] =  $data['USN'];
      } else {
        $response = array(
          'error_message' => 'No information received.',
          'result_code' => 1
        );
        return json_encode($response);
      }

      $results = $this->UserModel->select_hashpw_from_user_table($user);

      if ($results) {

        if (password_verify($user['password'], $results['hashed_pwd'])) {
          $user['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);

          if ($this->UserModel->update_user_set_password($user) >= 0) {

            $response = array(
              'success_message' => 'Password change is completed.',
              'result_code' => 0
            );
            return json_encode($response);

          } else {
            $response = array(
              'error_message' => 'Password is not changed.',
              'result_code' => 1
            );
            return json_encode($response);
           
          }
        } else {
          $response = array(
            'error_message' => 'Password Change is Failed, Password is wrong.',
            'result_code' => 1
          );
          return json_encode($response);
        }
      } else {
        $response = array(
          'error_message' => 'User does not exist in table. Please, Sign-in first.',
          'result_code' => 1
        );
        return json_encode($response);
      }
    } catch (PDOException $e) {
      $response = array(
        'error_message' => 'Some errors occurred during password change.',
        'result_code' => 1
      );
      return json_encode($response);
      
    }

  }


  //============================================================================================
  //  Forgotten password Change
  //============================================================================================

  public function app_forgotton_pw_change_request(Request $request, Response $response, $args)
  {
    $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
    $data = json_decode($json, true);
    try {

      if (isset($data['e_mail'])) {
        $user['e_mail'] =  $data['e_mail'];
      } else {
        $response = array(
          'error_message' => 'There is no E-mail.',
          'result_code' => 1
        );
        return json_encode($response);

      }

      $results = $this->UserModel->duplicate_check_by_email_from_user_table($user);
      if (count($results) == 1) { // Only one account is exist with the e-mail entered
        $user['USN'] = $results[0]['USN'];
        $temp =  password_hash(strval(mt_rand()), PASSWORD_DEFAULT);
        $user['auth_code'] = str_replace(array('\\', '/', '.'), strval(mt_rand()), $temp); //generate new auth_code
        for ($i = 0; $i <= 6; $i++) {
          $user['auth_code'][$i] =  strval(mt_rand());
        }

        if ($this->UserModel->update_user_set_auth_code($user) >= 0) {

          $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
          try {
            // Server settings
            $mail->isSMTP();                                        // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                         // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                 // Enable SMTP authentication
            $mail->Username = 'dmsrb1595@gmail.com';                 // SMTP username
            $mail->Password = 'P@ssw0rd123!@';                           // SMTP password
            $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                      // TCP port to connect to

            //Recipients
            $auth_url =  'http://localhost:8888/account/resetpasswd/' . $user['auth_code'];
            $mail->setFrom('dmsrb1595@gmail.com', 'Team D');
            $mail->addAddress($user['e_mail'], 'Team D');         // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Authentication E-mail from "Fresh Your Route"!!';
            $mail->Body    = 'I’m sorry that you lost your password.
            <br>If you want to reset your acccount password, Please,' . "<a href=\"$auth_url\">
            Click Here </a><p>";

            $mail->send();
            $response = array(
              'success_message' => 'Authentication-mail has been sent. Please, check your E-mail.',
              'result_code' => 0
            );
            return json_encode($response);

          } catch (Exception $e) {
            $response = array(
              'error_message' => 'Authentication-mail could not be sent. Try again.',
              'result_code' => 1
            );
            return json_encode($response);
  
          } // end of catch statement 
        } else {

          $response = array(
            'error_message' => 'Some errors occurred during forgotten password change.',
            'result_code' => 1
          );
          return json_encode($response);
        }
      } else {  // There is no user information or There is more than two user information.
        
        $response = array(
          'error_message' => 'E-mail does not exist in the table. Please, Sign-up first',
          'result_code' => 1
        );
  
      }
    } catch (PDOException $e) {
      $response = array(
        'error_message' => 'Some errors occurred during forgotten password change.',
        'result_code' => 1
      );
      return json_encode($response);
    }
  

  }

  //============================================================================================
  //  ID Cancellation
  //============================================================================================

  public function app_ID_cancellation_request(Request $request, Response $response, $args)
  {
    $json = file_get_contents('php://input'); //allows the server to read raw POST data from the request body.
    $data = json_decode($json, true);

    $json = [];
    $user = [];
    try {

      if (isset($data['USN']) && isset($data['password'])) {
        $user['password'] =  $data['password'];
        $user['USN'] =  $data['USN'];
      } else {

        $response = array(
          'error_message' => 'There is no password or Please, Sign-in first.',
          'result_code' => 1
        );
        return json_encode($response);
      }

      $results = $this->UserModel->select_hashpw_from_user_table($user);

      if ($results) {

        if (password_verify($user['password'], $results['hashed_pwd'])) {
          $user['isActive'] = 0;  // set isActive flag to 0. it is mean that user account is cancelled.

          if ($this->UserModel->update_user_set_isActive($user) >= 0) { //update database 
            
            $response = array(
              'success_message' => 'ID cancellation is completed.',
              'result_code' => 0
            );
            return json_encode($response);

          } else {

            $response = array(
              'error_message' => 'Some errors occurred during ID Cancellation.',
              'result_code' => 1
            );
            return json_encode($response);
          }
        } else {

          $response = array(
            'error_message' => 'ID cancellation is Failed, Password is wrong.',
            'result_code' => 1
          );
          return json_encode($response);

        }
      } else {
        $response = array(
          'error_message' => 'Some errors occurred during ID Cancellation.',
          'result_code' => 1
        );
        return json_encode($response);

      }
    } catch (PDOException $e) {
      $response = array(
        'error_message' => 'Some errors occurred during ID Cancellation.',
        'result_code' => 1
      );
      return json_encode($response);
    }

  }


}
