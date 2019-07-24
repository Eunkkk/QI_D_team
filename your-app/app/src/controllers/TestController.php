public function activate(Request $Request, Response $response, $args){
	// use clicked link with "nonce" = '234oajfioajfdsf'
	// select id from users where nonce = '234oajfioajfdsf';
	//if found, then activate account
		//update users set isActivate= 1 where id = $id
	// if not found, then give user error message
		//the account could not be activated. please check pw
}

//user clicks RESET PASSWORD button
//user fills in EMAIL on RESET PASSWORD form page
//user hits submit button
//request get sent to server
//server sends email to user with a link to click
//link looks like http://mailgun.net/accoint/reset/asesjeofjeioafjdisa

public function reset (Request $Request, Response $response, $args){
    //SELECT id FROM users WHERE nonce = 'fjewaofjeioa';
   //if found, then user is owner, so give user the new password page
   //if not found, give error
}

public function signup (Request $Request, Response $response, $args){
    //make sure to use the password_hash($plaintext, PASSWORD_DEFAULT) function when saving hash password to db
}

public function signin (Request $Request, Response $response, $args){
    //use the password_verify to check the password
    //how do you do this?
    //when somone signs in, they send email and password
    //write query to find account password
      //if found, use password_varify to see if the FORM password ($_POST['password'] matches the db hashed password.
      //if TRUE, then set SESSION variable
         //such as $_SESSION['login_in] = 1 
         //or $_SESSION['active']=1
         
         // you might have $_SESSION['isAdmin']=1
      //if FALSE, give error massage
      