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
  protected $SensorModel;

  public function __construct($logger, $UserModel, $view, $SensorModel)
  {
    $this->logger = $logger;
    $this->UserModel = $UserModel;
    $this->view = $view;
    $this->SensorModel = $SensorModel;
  }

  //============================================================================================
  //  page rendering
  //============================================================================================

  public function test(Request $request, Response $response, $args)
  {
    $this->view->render($response, 'test.html');
    return $response;
  }

  public function index(Request $request, Response $response, $args)
  {
    $this->view->render($response, 'index.twig');
    return $response;
  }

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


  //============================================================================================
  //  API
  //============================================================================================


  //============================================================================================
  //  Sign-up
  //============================================================================================

  public function sign_up_request(Request $request, Response $response, $args)
  {
    $user=[];
    try {

      if (isset($_POST['e_mail']) || isset($_POST['password']) 
      || isset($_POST['confirm_password'])|| isset($_POST['first_name'])|| isset($_POST['last_name'])
      || isset($_POST['birth_date'])) {
      
      $user['e_mail'] =  $_POST['e_mail'];
      $user['first_name'] =  $_POST['first_name'];
      $user['last_name'] =  $_POST['last_name'];
      $user['birth_date'] =  $_POST['birth_date'];
      $user['timestamp'] =  date("Y-m-d H:i:s");
      $user['hashed_pwd'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
      $temp =  password_hash(strval(mt_rand()), PASSWORD_DEFAULT);   // Create auth_code by random value and hash function
      $user['auth_code'] = str_replace(array('\\', '/', '.'), strval(mt_rand()), $temp);
      for ($i = 0; $i <= 6; $i++) {
        $user['auth_code'][$i] =  strval(mt_rand());
      }
      } else {
        $json = ['error_message' => 'No information received.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      if (strcmp($_POST['password'], $_POST['confirm_password']) !== 0) { //if The passwords do not match.
        $json = ['error_message' => 'Two password are different.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      if (count($this->UserModel->duplicate_check_by_email_from_user_table($user)) >= 1) {   //User does exist in "User" table
        $json = ['error_message' => 'This E-mail has already been signed up.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      } else {  //User doesn't exist in "User" table
        if (count($this->UserModel->duplicate_check_by_email_from_temp_user_table($user)) != 0) {
          //but User does exist in "Temp_user" table
          $json = ['error_message' => 'We have already received your sign-up request and authentication-mail has been sent. 
          Please, Check your E-mail again.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } else {    //User doesn't exist in "User" and "Temp_user" table

          $query_results =  $this->UserModel->insert_user_into_temp_table($user);
          
          if ($query_results>0) { // if insert query is successful, 0 is fail
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
              $mail->addAddress($user['e_mail'], 'Team D');          // Add a recipient
              $mail->isHTML(true);                                  // Set email format to HTML
              $mail->Subject = 'Authentication E-mail from "Fresh Your Route"!!';
              $mail->Body    = '<table class="wrapper" style="border-collapse: collapse;table-layout: fixed;min-width: 320px;width: 100%;background-color: #f2f2f2;" cellpadding="0" cellspacing="0" role="presentation"><tbody><tr><td>
              <div role="banner">
                <div class="preheader" style="Margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000% - 167440px);">
                  <div style="border-collapse: collapse;display: table;width: 100%;">
                  <!--[if (mso)|(IE)]><table align="center" class="preheader" cellpadding="0" cellspacing="0" role="presentation"><tr><td style="width: 280px" valign="top"><![endif]-->
                    <div class="snippet" style="display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000% - 78120px);padding: 10px 0 5px 0;color: #b8b8b8;font-family: Ubuntu,sans-serif;">
        
                    </div>
                  <!--[if (mso)|(IE)]></td><td style="width: 280px" valign="top"><![endif]-->
                    <div class="webversion" style="display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100% - 78680px);padding: 10px 0 5px 0;text-align: right;color: #b8b8b8;font-family: Ubuntu,sans-serif;">
        
                    </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  </div>
                </div>
        
              </div>
              <div>
              <div class="layout one-col fixed-width" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                <div class="layout__inner" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" emb-background-style>
                <!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0" role="presentation"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
                  <div class="column" style="text-align: left;color: #60666d;font-size: 14px;line-height: 21px;font-family: sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);">
        
                <div style="font-size: 12px;font-style: normal;font-weight: normal;line-height: 19px;" align="center">
                  <img style="border: 0;display: block;height: auto;width: 100%;max-width: 600px;" alt="" width="600" src="https://i.imgur.com/lRQ93jn.jpg" />
                </div>
        
                    <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 20px;">
              <div style="mso-line-height-rule: exactly;line-height: 10px;font-size: 1px;">&nbsp;</div>
            </div>
        
                    <div style="Margin-left: 20px;Margin-right: 20px;">
              <div style="mso-line-height-rule: exactly;mso-text-raise: 4px;">
                <h2 style="Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #43464a;font-size: 17px;line-height: 26px;">Thanks for joining "Your Fresh Route"!!</h2><p style="Margin-top: 16px;Margin-bottom: 20px;">Please confirm your email address to activate your account.</p>
              </div>
            </div>
        
                    <div style="Margin-left: 20px;Margin-right: 20px;">
              <div class="btn btn--flat btn--large" style="Margin-bottom: 20px;text-align: center;">
                <![if !mso]><a href="http://teamd-iot.calit2.net/account/resetpasswd/'.$user['auth_code'].'">Confirm my address</a><![endif]>
             </div>
            </div>
        
                    <div style="Margin-left: 20px;Margin-right: 20px;">
              <div style="mso-line-height-rule: exactly;line-height: 10px;font-size: 1px;">&nbsp;</div>
            </div>
        
                    <div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
              <div style="mso-line-height-rule: exactly;mso-text-raise: 4px;">
                <p style="Margin-top: 0;Margin-bottom: 0;">Qualcomm Institute Summer Project<br />
        <strong>Team D</strong></p>
              </div>
            </div>
        
                  </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </div>
              </div>
        
        
              <div role="contentinfo">
                <div class="layout email-footer" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                  <div class="layout__inner" style="border-collapse: collapse;display: table;width: 100%;">
                  <!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0" role="presentation"><tr class="layout-email-footer"><td style="width: 400px;" valign="top" class="w360"><![endif]-->
                    <div class="column wide" style="text-align: left;font-size: 12px;line-height: 19px;color: #b8b8b8;font-family: Ubuntu,sans-serif;Float: left;max-width: 400px;min-width: 320px; width: 320px;width: calc(8000% - 47600px);">
                      <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
        
                        <div style="font-size: 12px;line-height: 19px;">
        
                        </div>
                        <div style="font-size: 12px;line-height: 19px;Margin-top: 18px;">
        
                        </div>
                        <!--[if mso]>&nbsp;<![endif]-->
                      </div>
                    </div>
                  <!--[if (mso)|(IE)]></td><td style="width: 200px;" valign="top" class="w160"><![endif]-->
                    <div class="column narrow" style="text-align: left;font-size: 12px;line-height: 19px;color: #b8b8b8;font-family: Ubuntu,sans-serif;Float: left;max-width: 320px;min-width: 200px; width: 320px;width: calc(72200px - 12000%);">
                      <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
        
                      </div>
                    </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  </div>
                </div>
                <div class="layout one-col email-footer" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                  <div class="layout__inner" style="border-collapse: collapse;display: table;width: 100%;">
                  <!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0" role="presentation"><tr class="layout-email-footer"><td style="width: 600px;" class="w560"><![endif]-->
                    <div class="column" style="text-align: left;font-size: 12px;line-height: 19px;color: #b8b8b8;font-family: Ubuntu,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);">
                      <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
                        <div style="font-size: 12px;line-height: 19px;">
                          <unsubscribe style="text-decoration: underline;">http://teamd-iot.calit2.net/</unsubscribe>
                        </div>
                      </div>
                    </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  </div>
                </div>
              </div>
              <div style="line-height:40px;font-size:40px;">&nbsp;</div>
            </div></td></tr></tbody></table>';

              $mail->send();

              $json = ['success_message' => 'Authentication-mail has been sent. Please, check your E-mail.', 'result_code' => 0];
              return $response->withHeader('Content-type', 'application/json')
                ->write(json_encode($json));

           
            } catch (Exception $e) {
              $json = ['error_message' => 'Authentication-mail could not be sent. Try again.', 'result_code' => 1];
              return $response->withHeader('Content-type', 'application/json')
                ->write(json_encode($json));
            }
          } 
          else {  //else 
            $json = ['error_message' => 'Some errors occurred during sign-up.', 'result_code' => 1];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          }
        }
      }
    } catch (PDOException $e) {
      $json = ['error_message' => 'Some errors occurred during sign-up.', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($json));
    }
  }


  public function account_activate(Request $request, Response $response, $args) // When the user click a auth link to activate account
  {
    try {
      $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      $parts = parse_url($url);

      $nonce = substr($parts['path'], 22);  //parsing nonce

      $results = $this->UserModel->select_user_information_by_nonce_from_temp_table($nonce);

      if (count($results) == 1) { //Only one account exist with parsed nonce
        $results[0]['permission'] = 0;
        $results[0]['loginStateFlag'] = 0;
        $results[0]['isActive'] = 1;
        $results[0]['auth_code'] = NULL;
       
        if ($this->UserModel->insert_user_into_user_table($results[0])>0) {  //insert user information into user table
          if ($this->UserModel->delete_from_temp_user_table($nonce) > 0) { //delete user information from temp user table 

            $this->view->render($response, 'signin.twig', ['success_message'
            => 'Your account is activated.', 'result_code' => 0]);
            return $response;
          } else {
            $this->view->render($response, 'signin.twig', ['error_message'
            => 'Some errors occurred during account activation.', 'result_code' => 1]);
            return $response;
          }
        } else {
          $this->view->render($response, 'signin.twig', ['error_message'
          => 'Some errors occurred during sign-up.', 'result_code' => 1]);
          return $response;
        }
      } else {
        $this->view->render($response, 'signin.twig', ['error_message'
        => 'Some errors occurred during sign-up.', 'result_code' => 1]);
        return $response;
      }
    } catch (PDOException $e) {
      $this->view->render($response, 'signin.twig', ['error_message'
      => 'Some errors occurred during sign-up.', 'result_code' => 1]);
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
        $json = ['error_message' => 'There is no e_mail or pssword.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      $results = $this->UserModel->select_USN_PW_from_User_table($user); // select USN and hashed_pwd from User table 

      if ($results) {

        if (password_verify($user['password'], $results['hashed_pwd'])) {
          $user['USN'] = $results['USN'];
          $results['loginStateFlag'] = 1; //set login state flage to 1
          $results['isActive'] = 1; //set login state flage to 1

          if ($this->UserModel->update_user_set_loginStateFlag($results) >= 0) {
            $user['permission'] = $this->UserModel->select_permission_from_user_table($results);

            $json = [
              'success_message' => 'Sign-In is completed.', 'USN' => $user['USN'], 'e_mail'=>$user['e_mail'],
              'permission' => $user['permission'], 'result_code' => 0
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          } else {
            
            $json = ['error_message' => 'Some errors occurred during sign-in.', 'result_code' => 1];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          }
        } else {
          $json = ['error_message' => 'Sign-In is Failed, Password is wrong.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
      } else {

        $json = ['error_message' => 'E-mail does not exist, Please, sign-up first.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    } 

    catch (PDOException $e) {
      $json = ['error_message' => 'Some errors occurred during sign-in.', 'result_code' => 1];
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
        $user['loginStateFlag'] = 0; // set login state flag to 0 
        $user['isActive']=1;
      } else {
        $json = ['error_message' => 'Please, Sign-in first.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      if ($this->UserModel->update_user_set_loginStateFlag($user) >= 0) {

        $json = ['success_message' => 'You have been logged-out.', 'result_code' => 0];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      } else {
        $json = ['error_message' => 'Some errors occurred during sign-out.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    } catch (PDOException $e) {
      $json = ['error_message' => 'Some errors occurred during sign-out', 'result_code' => 1];
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
        $json = ['error_message' => 'There is no password or Please, Sign-in first.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      $results = $this->UserModel->select_hashpw_from_user_table($user);

      if ($results) {

        if (password_verify($user['password'], $results['hashed_pwd'])) {
          $user['isActive'] = 0;  // set isActive flag to 0. it is mean that user account is cancelled.
          $user['regActive'] = 0;
          if ($this->UserModel->update_user_set_isActive($user) >= 0) { //update database 

            if($this->SensorModel->update_sensor_info_set_regAtive_by_USN($user)>=0){
              $json = [
                'success_message' => 'ID cancellation is completed.', 'result_code' => 0
              ];
              return $response->withHeader('Content-type', 'application/json')
                ->write(json_encode($json));
            }else{
              $json = [
                'error_message' => 'Some errors occurred during ID Cancellation.', 'result_code' => 1
              ];
              return $response->withHeader('Content-type', 'application/json')
                ->write(json_encode($json));
            }
      
          } else {

            $json = [
              'error_message' => 'Some errors occurred during ID Cancellation.', 'result_code' => 1
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          }
        } else {
          $json = [
            'error_message' => 'ID cancellation is Failed, Password is wrong.', 'result_code' => 1
          ];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
      } else {

        $json = [
          'error_message' => 'Some errors occurred during ID Cancellation.', 'result_code' => 1
        ];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    } catch (PDOException $e) {
      $json = ['error_message' => 'Some errors occurred during ID Cancellation.', 'result_code' => 1];
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
        $json = ['error_message' => 'No information received.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }

      $results = $this->UserModel->select_hashpw_from_user_table($user);

      if ($results) {

        if (password_verify($user['password'], $results['hashed_pwd'])) {
          $user['new_password'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

          if ($this->UserModel->update_user_set_password($user) >= 0) {

            $json = [
              'success_message' => 'Password change is completed.', 'result_code' => 0
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          } else {

            $json = [
              'error_message' => 'Some errors occurred during password change.', 'result_code' => 1
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          }
        } else {
          $json = [
            'error_message' => 'Password Change is Failed, Password is wrong.', 'result_code' => 1
          ];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
      } else {

        $json = [
          'error_message' => 'Some errors occurred during password change.', 'result_code' => 1
        ];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
    } catch (PDOException $e) {
      $json = ['error_message' => 'Some errors occurred during password change.', 'result_code' => 1];
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
        $json = ['error_message' => 'There is no E-mail.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
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
            $mail->Password = 'znjfzja1!';                           // SMTP password
            $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                      // TCP port to connect to

            //Recipients
            $auth_url =  'http://teamd-iot.calit2.net/account/resetpasswd/' . $user['auth_code'];
            $mail->setFrom('dmsrb1595@gmail.com', 'Team D');
            $mail->addAddress($user['e_mail'], 'Team D');         // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Authentication E-mail from "Fresh Your Route"!!';
     
              $mail->Body    = '<table class="wrapper" style="border-collapse: collapse;table-layout: fixed;min-width: 320px;width: 100%;background-color: #f2f2f2;" cellpadding="0" cellspacing="0" role="presentation"><tbody><tr><td>
              <div role="banner">
                <div class="preheader" style="Margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000% - 167440px);">
                  <div style="border-collapse: collapse;display: table;width: 100%;">
                  <!--[if (mso)|(IE)]><table align="center" class="preheader" cellpadding="0" cellspacing="0" role="presentation"><tr><td style="width: 280px" valign="top"><![endif]-->
                    <div class="snippet" style="display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000% - 78120px);padding: 10px 0 5px 0;color: #b8b8b8;font-family: Ubuntu,sans-serif;">
        
                    </div>
                  <!--[if (mso)|(IE)]></td><td style="width: 280px" valign="top"><![endif]-->
                    <div class="webversion" style="display: table-cell;Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100% - 78680px);padding: 10px 0 5px 0;text-align: right;color: #b8b8b8;font-family: Ubuntu,sans-serif;">
        
                    </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  </div>
                </div>
        
              </div>
              <div>
              <div class="layout one-col fixed-width" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                <div class="layout__inner" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" emb-background-style>
                <!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0" role="presentation"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
                  <div class="column" style="text-align: left;color: #60666d;font-size: 14px;line-height: 21px;font-family: sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);">
        
                <div style="font-size: 12px;font-style: normal;font-weight: normal;line-height: 19px;" align="center">
                  <img style="border: 0;display: block;height: auto;width: 100%;max-width: 600px;" alt="" width="600" src="https://i.imgur.com/lRQ93jn.jpg" />
                </div>
        
                    <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 20px;">
              <div style="mso-line-height-rule: exactly;line-height: 10px;font-size: 1px;">&nbsp;</div>
            </div>
        
                    <div style="Margin-left: 20px;Margin-right: 20px;">
              <div style="mso-line-height-rule: exactly;mso-text-raise: 4px;">
                <h2 style="Margin-top: 0;Margin-bottom: 0;font-style: normal;font-weight: normal;color: #43464a;font-size: 17px;line-height: 26px;">I’m sorry that you lost your password. </h2><p style="Margin-top: 16px;Margin-bottom: 20px;">If you want to reset your acccount password, Please</p>
              </div>
            </div>
        
                    <div style="Margin-left: 20px;Margin-right: 20px;">
              <div class="btn btn--flat btn--large" style="Margin-bottom: 20px;text-align: center;"> 
                <![if !mso]><a href="http://teamd-iot.calit2.net/account/resetpasswd/'.$user['auth_code'].'">Click Here.</a><![endif]>
             </div>
            </div>
        
                    <div style="Margin-left: 20px;Margin-right: 20px;">
              <div style="mso-line-height-rule: exactly;line-height: 10px;font-size: 1px;">&nbsp;</div>
            </div>
        
                    <div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
              <div style="mso-line-height-rule: exactly;mso-text-raise: 4px;">
                <p style="Margin-top: 0;Margin-bottom: 0;">Qualcomm Institute Summer Project<br />
        <strong>Team D</strong></p>
              </div>
            </div>
        
                  </div>
                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </div>
              </div>
        
        
              <div role="contentinfo">
                <div class="layout email-footer" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                  <div class="layout__inner" style="border-collapse: collapse;display: table;width: 100%;">
                  <!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0" role="presentation"><tr class="layout-email-footer"><td style="width: 400px;" valign="top" class="w360"><![endif]-->
                    <div class="column wide" style="text-align: left;font-size: 12px;line-height: 19px;color: #b8b8b8;font-family: Ubuntu,sans-serif;Float: left;max-width: 400px;min-width: 320px; width: 320px;width: calc(8000% - 47600px);">
                      <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
        
                        <div style="font-size: 12px;line-height: 19px;">
        
                        </div>
                        <div style="font-size: 12px;line-height: 19px;Margin-top: 18px;">
        
                        </div>
                        <!--[if mso]>&nbsp;<![endif]-->
                      </div>
                    </div>
                  <!--[if (mso)|(IE)]></td><td style="width: 200px;" valign="top" class="w160"><![endif]-->
                    <div class="column narrow" style="text-align: left;font-size: 12px;line-height: 19px;color: #b8b8b8;font-family: Ubuntu,sans-serif;Float: left;max-width: 320px;min-width: 200px; width: 320px;width: calc(72200px - 12000%);">
                      <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
        
                      </div>
                    </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  </div>
                </div>
                <div class="layout one-col email-footer" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;">
                  <div class="layout__inner" style="border-collapse: collapse;display: table;width: 100%;">
                  <!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0" role="presentation"><tr class="layout-email-footer"><td style="width: 600px;" class="w560"><![endif]-->
                    <div class="column" style="text-align: left;font-size: 12px;line-height: 19px;color: #b8b8b8;font-family: Ubuntu,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);">
                      <div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
                        <div style="font-size: 12px;line-height: 19px;">
                          <unsubscribe style="text-decoration: underline;">http://teamd-iot.calit2.net/</unsubscribe>
                        </div>
                      </div>
                    </div>
                  <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                  </div>
                </div>
              </div>
              <div style="line-height:40px;font-size:40px;">&nbsp;</div>
            </div></td></tr></tbody></table>';

            $mail->send();

            $json = ['success_message' => 'Authentication-mail has been sent. Please, check your E-mail.', 'result_code' => 0];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          } catch (Exception $e) {

            $json = [
              'error_message' => 'Authentication-mail could not be sent. Try again.', 'result_code' => 1
            ];
            return $response->withHeader('Content-type', 'application/json')
              ->write(json_encode($json));
          } // end of catch statement 
        } else {

          $json = [
            'error_message' => 'Some errors occurred during forgotten password change.', 'result_code' => 1
          ];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
      } else {  // There is no user information or There is more than two user information.
        $json = [
          'error_message' => 'E-mail does not exist.', 'result_code' => 1
        ];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
  
      }
    } catch (PDOException $e) {
      $json = ['error_message' => 'Some errors occurred during forgotten password change.', 'result_code' => 1];
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

      $results = $this->UserModel->select_USN_by_nonce_from_user_table($nonce);
      if (count($results) == 1) {

        $this->view->render($response, 'fpwenter.twig',[ 'auth_code' => $nonce, 'USN' => $results[0]['USN'],
        'success_message'=>'Please, Enter Your new password.', 'result_code' => 0]);
        return $response;

      
      }else{
        $json = ['error_message' => 'Some errors occurred during forgotten password change.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }


    } catch (PDOException $e) {
      $json = ['error_message' => 'Some errors occurred during forgotten password change.', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($results));
    }
  }

  public function account_resetpasswd2(Request $request, Response $response, $args) // When the user click a auth link to reset account password
  {
    $json = [];
    $user = [];

    try {
      if (isset($_POST['new_password']) || isset($_POST['confirm_new_password'])) {
        $user['new_password'] =  $_POST['new_password'];
        $user['confirm_new_password'] =  $_POST['confirm_new_password'];

      } else {
        $json = ['error_message' => 'No information received.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($json));
      }
  

      $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      $parts = parse_url($url);

      $nonce = substr($parts['path'], 22);   //parsing nocne

      $results = $this->UserModel->select_USN_by_nonce_from_user_table($nonce);
      if (count($results) == 1) {  // Only one account is exist with the parsed nonce
        $user['USN'] = $results[0]['USN'];
        $user['hashed_pwd'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT); //hasing password
        $user['auth_code'] =  NULL;   //update auth_code 
 
        if ($this->UserModel->update_user_set_password_auth_code($user)>=0) {
 
   
          $json = ['success_message' => 'Forgotten password change is completed. ', 'result_code' => 0];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        } else {
          $json = ['error_message' => 'Some errors occurred during forgotten password change.', 'result_code' => 1];
          return $response->withHeader('Content-type', 'application/json')
            ->write(json_encode($json));
        }
      } else {
        $json = ['error_message' => 'Some errors occurred during forgotten password change.', 'result_code' => 1];
        return $response->withHeader('Content-type', 'application/json')
          ->write(json_encode($results));
      }
    } catch (PDOException $e) {
      $json = ['error_message' => 'Some errors occurred during forgotten password change.', 'result_code' => 1];
      return $response->withHeader('Content-type', 'application/json')
        ->write(json_encode($results));
    }
  }

} // end of UserController
