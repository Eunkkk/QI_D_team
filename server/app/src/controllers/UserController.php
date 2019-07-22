<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

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

    public function duplicate_check(Request $request, Response $response, $args)
    {
      $user['e_mail'] =  $_POST['e_mail'];

      if ($this->UserModel->duplicate_check_by_email($user['e_mail'])) {
        $json['status']= 'error';
        $json['message']= 'E-mail address already exsits';

        return $response->withHeader('Content-type','application/json')
            ->withStatus(400)
            ->write(json_encode($json));

        } else {

          return $response->withHeader('Content-type','application/json')
              ->withStatus(200)
              ->write(json_encode($user));
        }
    }
    public function sign_up_request(Request $request, Response $response, $args)
    {
      if ($this->UserModel->duplicate_check_by_email($user['e_mail'])) {
            return $response->withHeader('Content-type','application/json')
            ->withStatus(400)
            ->write(json_encode($json));

        } else {
          $json['status']= 'success';
          $json['message']= 'E-mail address not found';

          $user['e_mail'] =  $_POST['e_mail'];
          $user['first_name'] =  $_POST['first_name'];
          $user['last_name'] =  $_POST['last_name'];
          $user['birth_date'] =  $_POST['birth_date'];
          $user['timestamp'] =  date("Y-m-d H:i:s");
          $user['hashed_pwd'] =  password_hash($_POST['password'],PASSWORD_DEFAULT);
          $user['auth_code'] =  password_hash(strval(mt_rand()),PASSWORD_DEFAULT);
          $user['permission'] =  0;
          $user['loginStateFlag'] =  0;

          $this->UserModel->insert_user_into_temp_table($user);

        return $response->withHeader('Content-type','application/json')
        ->withStatus(200)
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

    public function sign_in(Request $request, Response $response, $args)
    {
      // echo 'asdf';
      // $view->render($response,'signin.twig');
      $this->view->render($response, 'signin.twig');
      return $response;
      //user clicked link with "nonce" = ' asdfasdfasdfadsf' nonce 값 추가
      //SELECT id FROM User Where nonce = 'asdfsadfsdfsadf';
      //if FOUND, then activate $account
        //Update users set isactive = 1 ****** where id = $id; where 이 중요 !
      //if not found, then give User error Message
        // The account could not be activated, Please check your link

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
