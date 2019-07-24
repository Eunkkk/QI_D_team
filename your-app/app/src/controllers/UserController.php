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

      public function __construct($logger, $UserModel,$view)
      {
          $this->logger = $logger;
          $this->UserModel = $UserModel;
          $this->view = $view;
      }

      public function send_mail(Request $request, Response $response, $args) {
        // $this->getApp()->contentType('text/html');
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'dmsrb1595@gmail.com';                 // SMTP username
            $mail->Password = 'znjfzja1!';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            $user['e_mail'] = $_POST['e_mail'];
            $user['auth_code']=$_POST['auth_code'];
            //Recipients
            $mail->setFrom('dmsrb1595@gmail.com', 'Team D');
            $mail->addAddress('dmsrb1595@gmail.com', 'Team D');     // Add a recipient
    //        $mail->addAddress('ellen@example.com');               // Name is optional
    //        $mail->addReplyTo('info@example.com', 'Information');
    //        $mail->addCC('cc@example.com');
    //        $mail->addBCC('bcc@example.com');

            //Attachments
      //            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      //            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
      //        $this->render("index/mail.phtml");
      exit;

        return $response;

      }

      public function sign_up(Request $request, Response $response, $args)
      {
        // echo 'asdf';
        // $view->render($response,'signin.twig');
        $this->view->render($response, 'signup.twig');
        return $response;
        //user clicked link with "nonce" = ' asdfasdfasdfadsf' nonce 값 추가
        //SELECT id FROM User Where nonce = 'asdfsadfsdfsadf';
        //if FOUND, then activate $account
          //Update users set isactive = 1 ****** where id = $id; where 이 중요 !
        //if not found, then give User error Message
          // The account could not be activated, Please check your link
      }


      public function account_activate(Request $request, Response $response, $args)
    {
      
      //===============================================================================
      // 클릭 뒤에 nonce 값으로 DB 찾아서 temp -> User 테이블로 옮기기
      // active = 1 , auth_code = 0
      //======================================================================

      //===============================================================================
      // temp 에서 삭제
      //======================================================================

      echo ' this is activate..';

    }
    public function sign_up_request(Request $request, Response $response, $args)
    {
      try {
        $user['e_mail'] =  $_POST['e_mail'];

        if ($this->UserModel->duplicate_check_by_email($user)) {
          $json['status']= 'error';
          $json['message']= 'E-mail address found';
              return $response->withHeader('Content-type','application/json')
              ->withStatus(400)
              ->write(json_encode($json));

          } else {

            //인증 메일을 보내서 메일에서 nonce 값 요청이 오고

            $json['status']= 'success';
            $json['message']= 'E-mail address not found';

            $user['first_name'] =  $_POST['first_name'];
            $user['last_name'] =  $_POST['last_name'];
            $user['birth_date'] =  $_POST['birth_date'];
            $user['timestamp'] =  date("Y-m-d H:i:s");
            $user['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
            $temp =  password_hash(strval(mt_rand()),PASSWORD_DEFAULT);
            $user['auth_code'] = str_replace("/","\\",$temp); // replace  '/' to '\'

          // $query_results =  $this->UserModel->insert_user_into_temp_table($user);

//===============================================================================
    //유저한테 메일보내기

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'dmsrb1595@gmail.com';                 // SMTP username
            $mail->Password = 'znjfzja1!';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('dmsrb1595@gmail.com', 'Team D');
            $mail->addAddress($user['e_mail'], 'Team D');     // Add a recipient
            //        $mail->addAddress('ellen@example.com');               // Name is optional
            //        $mail->addReplyTo('info@example.com', 'Information');
            //        $mail->addCC('cc@example.com');
            //        $mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'The Auth link is http://teamd-iot.calit2.net/user/signin/activate/'.$user['auth_code'];
            $mail->AltBody = 'The alt body link is http://teamd-iot.calit2.net/user/signin/activate/'.$user['auth_code'];

            $mail->send();
            echo 'Message has been sent'; // 팝업 으로보여주기 
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
          return $response->withHeader('Content-type','application/json')
          ->withStatus(200)
          ->write(json_encode($json));
          }

      } catch (PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
    }

    public function sign_in_page(Request $request, Response $response, $args)
    {
      $this->view->render($response, 'signin.twig');
      return $response;
    }

    public function sign_in_request(Request $request, Response $response, $args)
    {
      $user['e_mail'] =  $_POST['e_mail'];
      $user['password'] = $_POST['password'];
      $results = $this->UserModel->select_USN_PW_from_User_table($user);
      if ($results) {
        $json['status']= 'success';
        $json['message']= 'E-mail address not found';
        print_r($json);
        } else {
          $json['status']= 'error';
          $json['message']= 'E-mail address not found';

        return $response->withHeader('Content-type','application/json')
        ->withStatus(400)
        ->write(json_encode($json));
    }
  }


    public function sign_out(Request $request, Response $response, $args)
    {

      // $this->view->render($response, 'signin.twig');
      // return $response;
    // use the passwrod_verifty to check the password
    //how do you do this
    //when someone signs in, they send email and password
    //wirte query to find account  password
      //if found, use password _verify to see if the FORM password ($_POST['password'])
      //matches the database hashed
      //if True, then set SESSION define_syslog_variables
        //such as $_SESSION['logged_in'] = 1 페이지를 이동할때마다 로그인되어있는지 확인
        //or $_SESSION['logged_in']=1
      //if FLASE, give error message

        //you might have $_SESSION['isAdmin'] = 1


    }




    public function pw_change(Request $request, Response $response, $args)
    {
      $this->view->render($response, 'pwchange.twig');
      return $response;
      //SELECT id FROM User Where nonce = 'another nonceaaaaaa';
      //if FOUND, then user is owner , so give user the new password page
        //reset nonce to null
      //if not found, then give User error Message


    }

    public function forgotton_pw_change(Request $request, Response $response, $args)
    {
      $this->view->render($response, 'fpwchange.twig');
      return $response;
    }

    public function ID_cancellation(Request $request, Response $response, $args)
    {
      $this->view->render($response, 'IDCancellation.twig');
      return $response;
    }




    //User clicks RESET PASSWORD button -> 이것도 메일
    //User fills in EMAIL on RESEST PASSWORD form page -> 이메일로 보낸 뒤에 해야함
    //User jots submit button
    //REquest gets sent to server,
    //Server send Email to USER with to link to click


    //link looks like https://mail.gun.net/adsnkfjnasdkfn

}

// <?php
// namespace App\Controller;
//
// use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Message\ResponseInterface as Response;
//
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
//
// final class UCSDController extends BaseController
// {
//     public function helloworld(Request $request, Response $response, $args)
//     {
//       echo 'hello world';
//     }
//     public function sendmail(Request $request, Response $response, $args) //$args = $email
//    {
//     //   $mail = new PHPMailer(true);
//     //   try{
//     //     //server setting
//     //     $mail->SMTPDebug = 2;
//     //     $mail->isSMTP();
//     //     $mail->Host = 'smtp.gmail.com'; //set mailer to use SMTp
//     //     $mail->SMTPAuth = true;   //Enable SMTP authetication
//     //     $mail->UserName = 'whssodi@gmail.co,'; //SMTP password
//     //     $mail->Password = ''; //SMTP password
//     //     $mail->SMTPSEcure = 'tls';
//     //     $mail->Port = 587;    //tcp port connect to
//     //     //Recipients
//     //     $mail->setFrom('mail address','name');
//     //     $mail->addAddress($email); //Name is optional
//     //     $mail->addAddress('mail address','name');
//     //     $mail->addCC('CC@example.com');
//     //
//     //     //attachments
//     //
//     //     $mail->addAttachment('파일경로','파일이름');
//     //
//     //
//     //     $mail->isHTML(true);
//     //     $mail->Subject = 'Please activivate your account';
//     //     $mail->Body = '<b> body </b>';
//     //     $mail->AltBody = 'This is the body in plain text ';
//     //     $mail->send(true);
//     //     echo 'Message has benn sent';
//     //   //
//     //   }
//     //   catch(Exception $e){
//     //     echo 'Message could not be send.';
//     //     echo 'Mailer Error ', $mail->ErrorInfo;
//     //   }
//       $this->view->render($response, 'home.twig');
//       return $response;
//     }
//
//     public function signIn(Request $request, Response $response, $args) //$args = $email
//     {
//       /*
//       데이터베이스에서 회원가입이 이미되어있으면 회원가입이 되어있다고 알려줘야함
//
//       */
//       $this->view->render($response, 'login.twig');
//             // $this->view->render($response, 'signup.twig');
//       return $response;
//     }
//
//
//       public function signUp(Request $request, Response $response, $args) //$args = $email
//       {
//         /*
//         데이터베이스에서 회원가입이 이미되어있으면 회원가입이 되어있다고 알려줘야함
//
//         */
//         $myarray = array("yourname"=>$_POST['name'],"color"=>"Green","size"=>"large");
//         $account_exists = false;
//
//         $this->view->render($response, 'signup.twig',['myarray'=>$myarray,'fakevariable'=>"$1000 Million",'post'=> $_POST]);
//               // $this->view->render($response, 'signup.twig');
//         return $response;
//       }
//
//       public function handleSignUp(Request $request, Response $response, $args) //$args = $email
//       {
//           echo "I am going to check the database for your email address  ";
//           var_dump($_POST);
//           print_r($_POST);
//
//           //write sql HttpQueryString
//           // if $email found, then writethen  error Message
//           $email_found = 1;
//           if($email_found){
//             $status = "error";
//           }
//           else{
//               $status = "good";
//           }
//
//           // if $eamil not found, then save to database and then send mail
//           //
//       }
// }
