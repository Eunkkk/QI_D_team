<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* signup.twig */
class __TwigTemplate_8bfc34d5bcacfaa25e553619784ab482bb468404413bd71296359826e0a734b0 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"utf-8\">
        <meta content=\"width=device-width, initial-scale=1.0\" name=\"viewport\">
        <title>QI Team D Sign Up Page</title>
        <!-- Core CSS - Include with every page -->
        <link href=\"/assets/plugins/bootstrap/bootstrap.css\" rel=\"stylesheet\"/>
        <link href=\"/assets/font-awesome//css/font-awesome.css\" rel=\"stylesheet\"/>
        <link href=\"/assets/plugins/pace/pace-theme-big-counter.css\" rel=\"stylesheet\"/>
        <link href=\"/assets//css/style.css\" rel=\"stylesheet\"/>
        <link
        href=\"/assets//css/main-style.css\" rel=\"stylesheet\"/>

        ";
        // line 16
        echo "        <link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\">
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
        ";
        // line 20
        echo "
    </head>

    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>
    <script type=\"text/javascript\">
var request;
        \$(document).ready(function () {
            \$(\"#password, #confirm_password\").keyup(checkPasswordMatch);
            \$(\"#password\").keyup(checkPasswordForm);
            \$(\"#e_mail\").keyup(checkEmailForm);

             \$('#clicksignup').click(function () {
                event.preventDefault();
                if (request) {
                    request.abort();
                }

                var ve_mail = \$(\"#e_mail\").val();
                var vpassword = \$(\"#password\").val();
                var vconfirm_password = \$(\"#confirm_password\").val();
                var vfirst_name = \$(\"#first_name\").val();
                var vlast_name = \$(\"#last_name\").val();
                var vbirth_date = \$(\"#birth_date\").val();
 
           request = \$.post('/user/signup/request', {
                e_mail: ve_mail,
                password: vpassword,
                confirm_password : vconfirm_password,
                first_name: vfirst_name,
                last_name : vlast_name,
                birth_date: vbirth_date
            }, function (returnedData) {
                console.log(returnedData);
            });

                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR) { // Log a message to the console

                    if (response.result_code==0) {
                            \$(\"#message\").html(response.success_message);
                             \$('#myModal').modal(\"show\");
                               setTimeout(function() { 
                                   window.location.replace(\"http://teamd-iot.calit2.net/user/signin\");
                                   }, 3000);
             
                    } else {
                          \$(\"#message\").html(response.error_message);
                          \$('#myModal').modal(\"show\");
                    }
                    
                });

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown) { // Log the error to the console
                        \$(\"#message\").html(\"The following error occurred: \" + textStatus, errorThrown);
                         \$('#myModal').modal(\"show\");
                    

                });
            });

        });


        function checkEmailForm() {

            var email = \$(\"#e_mail\").val();
            var email_regex = /^([a-zA-Z0-9_.+-])+\\@(([a-zA-Z0-9-])+\\.)+([a-zA-Z0-9]{2,4})+\$/;

            if (email_regex.test(email) == false) {
                var match = \"Enter a valid email address\"
                var result = match.fontcolor('red');
                \$(\"#divCheckEmailForm\").html(result);
            } else {
                var match = \"A valid email address \"
                var result = match.fontcolor('green');
                \$(\"#divCheckEmailForm\").html(result);
            }
        }

        function checkPasswordMatch() {
            var password = \$(\"#password\").val();
            var confirmPassword = \$(\"#confirm_password\").val();

            if (password != confirmPassword) {
                var match = \"The passwords do not match.\"
                var result = match.fontcolor('red');
                \$(\"#divCheckPasswordMatch\").html(result);
            } else {
                var match = \"The passwords match!\";
                var result = match.fontcolor('green');
                \$(\"#divCheckPasswordMatch\").html(result);
            }
        }

        function checkPasswordForm() {
            var password = \$(\"#password\").val();
            var password_regex1 = /([a-z].*[A-Z])|([A-Z].*[a-z])([0-9])+([!,%,&,@,#,\$,^,*,?,_,~])/;
            var password_regex2 = /([0-9])/;
            var password_regex3 = /([!,%,&,@,#,\$,^,*,?,_,~])/;

            if (password.length < 8 || password_regex1.test(password) == false || password_regex2.test(password) == false || password_regex3.test(password) == false) {
                var match = \"Password must be at least 8 Digits long and contains one upper case, one Lower case and one special character.\"
                var result = match.fontcolor('red');
                \$(\"#divCheckPasswordForm\").html(result);
            } else {
                var match = \"Good password.\"
                var result = match.fontcolor('green');
                \$(\"#divCheckPasswordForm\").html(result);
            }
        }


        function formCheck(frm) {
            if (frm.e_mail.value == \"\") {
                \$(\"#message\").html(\"Please enter your E-mail address\");
                 \$('#myModal').modal(\"show\");
                frm.e_mail.focus();
                return false;
            }
            if (frm.password.value == \"\") {
                \$(\"#message\").html(\"Please enter your password.\");
                 \$('#myModal').modal(\"show\");
                frm.password.focus();
                return false;
            }
            if (frm.confirm_password.value == \"\") {
                \$(\"#message\").html(\"Please enter your confirm password.\");
                \$('#myModal').modal(\"show\");
                frm.confirm_password.focus();
                return false;
            }
            if (frm.first_name.value == \"\") {
                \$(\"#message\").html(\"Please enter your fisrt name.\");
                \$('#myModal').modal(\"show\");
                frm.first_name.focus();
                return false;
            }
            if (frm.last_name.value == \"\") {
                \$(\"#message\").html(\"Please enter your last name.\");
                \$('#myModal').modal(\"show\");
                frm.last_name.focus();
                return false;
            }
            if (frm.birth_date.value == \"\") {
                \$(\"#message\").html(\"Please enter your birth_date.\");
                \$('#myModal').modal(\"show\");
                frm.birth_date.focus();
                return false;
            }

            var email = \$(\"#e_mail\").val();
            var pass = \$(\"#password\").val();
            var confirm = \$(\"#confirm_password\").val();
            var first = \$(\"#first_name\").val();
            var last = \$(\"#last_name\").val();
            var email_regex = /^([a-zA-Z0-9_.+-])+\\@(([a-zA-Z0-9-])+\\.)+([a-zA-Z0-9]{2,4})+\$/;
            var password_regex1 = /([a-z].*[A-Z])|([A-Z].*[a-z])([0-9])+([!,%,&,@,#,\$,^,*,?,_,~])/;
            var password_regex2 = /([0-9])/;
            var password_regex3 = /([!,%,&,@,#,\$,^,*,?,_,~])/;

            if (email_regex.test(email) == false) {
                \$(\"#message\").html(\"Please Enter Correct E-mail address.\");
                \$('#myModal').modal(\"show\");
                return false;
            } else if (pass.length < 8 || password_regex1.test(pass) == false || password_regex2.test(pass) == false || password_regex3.test(pass) == false) {
                \$(\"#message\").html(\"Password Must be at least 8 Digitslong and contains one UpperCase, one LowerCase and One special character.\");
                \$('#myModal').modal(\"show\");
                return false;
            } else if (password_regex2.test(first) == true || password_regex3.test(first) || password_regex2.test(last) == true || password_regex3.test(last)) {
                \$(\"#message\").html(\"Please enter the correct name format.\");
                \$('#myModal').modal(\"show\");
                return false;
            } else if (pass !== confirm) {
                \$(\"#message\").html(\"Passwords do not match.\");
                \$('#myModal').modal(\"show\");
                return false;
            }
            return true;
        }
    </script>

    ";
        // line 203
        echo "       <div class=\"modal fade\" id=\"myModal\">
            <div class=\"modal-dialog modal-lg modal-dialog-centered \" role=\"document\">
                <div class=\"modal-content \">
                    <div class=\"modal-header text-danger\">
                        <h4 class=\"modal-title \">Notification</h4>
                        <button aria-label=\"Close\" class=\"close\" data-dismiss=\"modal\" type=\"button\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <p id = \"message\"></p>
                    </div>
                    <div class=\"modal-footer\">
                        <button class=\"btn btn-secondary mx-auto\" data-dismiss=\"modal\" type=\"button\">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
    ";
        // line 223
        echo "
    <body class=\"body-Login-back\">
        <div class=\"container\">

            <div class=\"row\">
                <div class=\"col-md-4 col-md-offset-4 text-center logo-margin \">
                    <img alt=\"\" src=\"/assets/img/logo_new.png\"/>
                </div>
                <div class=\"col-md-4 col-md-offset-4\">
                    <div class=\"login-panel panel panel-default\">
                        <div class=\"panel-heading\">
                            <h3 class=\"panel-title\">Please, Sign Up</h3>
                        </div>
                        <div class=\"panel-body\">
                            <form  onsubmit=\"return formCheck(this)\">

                                <div class=\"form-group\">
                                    <label>Email address</label><br>
                                    <input autofocus class=\"form-control\" id=\"e_mail\" name=\"e_mail\" onchange=\"checkEmailForm();\" placeholder=\"E-mail\" type=\"email\">
                                    <div id=\"divCheckEmailForm\"></div>
                                    <br>
                                        <label>Password</label>
                                    </br>
                                    <input class=\"form-control\" id=\"password\" name=\"password\" placeholder=\"Password\" type=\"password\" value=\"\">
                                    <div id=\"divCheckPasswordForm\"></div>

                                    <br><label>Confirm Password</label>
                                    <input class=\"form-control\" id=\"confirm_password\" name=\"confirm_password\" onchange=\"checkPasswordMatch();\" placeholder=\"Confirm password\" type=\"password\" value=\"\"/>
                                    <div id=\"divCheckPasswordMatch\"></div>
                                    <br>
                                        <label>First Name</label>
                                    </br>
                                    <input class=\"form-control\" id=\"first_name\" name=\"first_name\" placeholder=\"First Name\" type=\"text\" value=\"\"></br>
                                <label>Last Name</label>
                            </br>
                            <input class=\"form-control\" id=\"last_name\" name=\"last_name\" placeholder=\"Last Name\" type=\"text\" value=\"\">
                        </div>
                        <label>Birth Date</label>
                    </br>
                    <input class=\"form-control\" id=\"birth_date\" name=\"birth_date\" placeholder=\"Birth Date\" type=\"date\" value=\"\"></br>
            </body>
        </html>
    </div>
    <!-- Change this to a button or input when using this as a form -->

    <div class=\"row text-center\" style=\"width: 100%\">
                    <a class=\"btn  btn-success\" href=\"/user/signin\">CANCEL</a>
                    <input class=\"btn  btn-success\" id=\"clicksignup\"type=\"submit\" value=\"COMPLETE\"/>
        </dev>
    </div>
</fieldset></form></div></div></div></div></div></div><!-- Core Scripts - Include with every page --><script src=\"/assets/plugins/jquery-1.10.2.js\"></script><script src=\"/assets/plugins/bootstrap/bootstrap.min.js\"></script><script src=\"/assets/plugins/metisMenu/jquery.metisMenu.js\"></script></body></html>

";
    }

    public function getTemplateName()
    {
        return "signup.twig";
    }

    public function getDebugInfo()
    {
        return array (  263 => 223,  242 => 203,  58 => 20,  53 => 16,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"utf-8\">
        <meta content=\"width=device-width, initial-scale=1.0\" name=\"viewport\">
        <title>QI Team D Sign Up Page</title>
        <!-- Core CSS - Include with every page -->
        <link href=\"/assets/plugins/bootstrap/bootstrap.css\" rel=\"stylesheet\"/>
        <link href=\"/assets/font-awesome//css/font-awesome.css\" rel=\"stylesheet\"/>
        <link href=\"/assets/plugins/pace/pace-theme-big-counter.css\" rel=\"stylesheet\"/>
        <link href=\"/assets//css/style.css\" rel=\"stylesheet\"/>
        <link
        href=\"/assets//css/main-style.css\" rel=\"stylesheet\"/>

        {# ===============================Modal===================================== #}
        <link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\">
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
        {# ==================================================================== #}

    </head>

    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>
    <script type=\"text/javascript\">
var request;
        \$(document).ready(function () {
            \$(\"#password, #confirm_password\").keyup(checkPasswordMatch);
            \$(\"#password\").keyup(checkPasswordForm);
            \$(\"#e_mail\").keyup(checkEmailForm);

             \$('#clicksignup').click(function () {
                event.preventDefault();
                if (request) {
                    request.abort();
                }

                var ve_mail = \$(\"#e_mail\").val();
                var vpassword = \$(\"#password\").val();
                var vconfirm_password = \$(\"#confirm_password\").val();
                var vfirst_name = \$(\"#first_name\").val();
                var vlast_name = \$(\"#last_name\").val();
                var vbirth_date = \$(\"#birth_date\").val();
 
           request = \$.post('/user/signup/request', {
                e_mail: ve_mail,
                password: vpassword,
                confirm_password : vconfirm_password,
                first_name: vfirst_name,
                last_name : vlast_name,
                birth_date: vbirth_date
            }, function (returnedData) {
                console.log(returnedData);
            });

                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR) { // Log a message to the console

                    if (response.result_code==0) {
                            \$(\"#message\").html(response.success_message);
                             \$('#myModal').modal(\"show\");
                               setTimeout(function() { 
                                   window.location.replace(\"http://teamd-iot.calit2.net/user/signin\");
                                   }, 3000);
             
                    } else {
                          \$(\"#message\").html(response.error_message);
                          \$('#myModal').modal(\"show\");
                    }
                    
                });

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown) { // Log the error to the console
                        \$(\"#message\").html(\"The following error occurred: \" + textStatus, errorThrown);
                         \$('#myModal').modal(\"show\");
                    

                });
            });

        });


        function checkEmailForm() {

            var email = \$(\"#e_mail\").val();
            var email_regex = /^([a-zA-Z0-9_.+-])+\\@(([a-zA-Z0-9-])+\\.)+([a-zA-Z0-9]{2,4})+\$/;

            if (email_regex.test(email) == false) {
                var match = \"Enter a valid email address\"
                var result = match.fontcolor('red');
                \$(\"#divCheckEmailForm\").html(result);
            } else {
                var match = \"A valid email address \"
                var result = match.fontcolor('green');
                \$(\"#divCheckEmailForm\").html(result);
            }
        }

        function checkPasswordMatch() {
            var password = \$(\"#password\").val();
            var confirmPassword = \$(\"#confirm_password\").val();

            if (password != confirmPassword) {
                var match = \"The passwords do not match.\"
                var result = match.fontcolor('red');
                \$(\"#divCheckPasswordMatch\").html(result);
            } else {
                var match = \"The passwords match!\";
                var result = match.fontcolor('green');
                \$(\"#divCheckPasswordMatch\").html(result);
            }
        }

        function checkPasswordForm() {
            var password = \$(\"#password\").val();
            var password_regex1 = /([a-z].*[A-Z])|([A-Z].*[a-z])([0-9])+([!,%,&,@,#,\$,^,*,?,_,~])/;
            var password_regex2 = /([0-9])/;
            var password_regex3 = /([!,%,&,@,#,\$,^,*,?,_,~])/;

            if (password.length < 8 || password_regex1.test(password) == false || password_regex2.test(password) == false || password_regex3.test(password) == false) {
                var match = \"Password must be at least 8 Digits long and contains one upper case, one Lower case and one special character.\"
                var result = match.fontcolor('red');
                \$(\"#divCheckPasswordForm\").html(result);
            } else {
                var match = \"Good password.\"
                var result = match.fontcolor('green');
                \$(\"#divCheckPasswordForm\").html(result);
            }
        }


        function formCheck(frm) {
            if (frm.e_mail.value == \"\") {
                \$(\"#message\").html(\"Please enter your E-mail address\");
                 \$('#myModal').modal(\"show\");
                frm.e_mail.focus();
                return false;
            }
            if (frm.password.value == \"\") {
                \$(\"#message\").html(\"Please enter your password.\");
                 \$('#myModal').modal(\"show\");
                frm.password.focus();
                return false;
            }
            if (frm.confirm_password.value == \"\") {
                \$(\"#message\").html(\"Please enter your confirm password.\");
                \$('#myModal').modal(\"show\");
                frm.confirm_password.focus();
                return false;
            }
            if (frm.first_name.value == \"\") {
                \$(\"#message\").html(\"Please enter your fisrt name.\");
                \$('#myModal').modal(\"show\");
                frm.first_name.focus();
                return false;
            }
            if (frm.last_name.value == \"\") {
                \$(\"#message\").html(\"Please enter your last name.\");
                \$('#myModal').modal(\"show\");
                frm.last_name.focus();
                return false;
            }
            if (frm.birth_date.value == \"\") {
                \$(\"#message\").html(\"Please enter your birth_date.\");
                \$('#myModal').modal(\"show\");
                frm.birth_date.focus();
                return false;
            }

            var email = \$(\"#e_mail\").val();
            var pass = \$(\"#password\").val();
            var confirm = \$(\"#confirm_password\").val();
            var first = \$(\"#first_name\").val();
            var last = \$(\"#last_name\").val();
            var email_regex = /^([a-zA-Z0-9_.+-])+\\@(([a-zA-Z0-9-])+\\.)+([a-zA-Z0-9]{2,4})+\$/;
            var password_regex1 = /([a-z].*[A-Z])|([A-Z].*[a-z])([0-9])+([!,%,&,@,#,\$,^,*,?,_,~])/;
            var password_regex2 = /([0-9])/;
            var password_regex3 = /([!,%,&,@,#,\$,^,*,?,_,~])/;

            if (email_regex.test(email) == false) {
                \$(\"#message\").html(\"Please Enter Correct E-mail address.\");
                \$('#myModal').modal(\"show\");
                return false;
            } else if (pass.length < 8 || password_regex1.test(pass) == false || password_regex2.test(pass) == false || password_regex3.test(pass) == false) {
                \$(\"#message\").html(\"Password Must be at least 8 Digitslong and contains one UpperCase, one LowerCase and One special character.\");
                \$('#myModal').modal(\"show\");
                return false;
            } else if (password_regex2.test(first) == true || password_regex3.test(first) || password_regex2.test(last) == true || password_regex3.test(last)) {
                \$(\"#message\").html(\"Please enter the correct name format.\");
                \$('#myModal').modal(\"show\");
                return false;
            } else if (pass !== confirm) {
                \$(\"#message\").html(\"Passwords do not match.\");
                \$('#myModal').modal(\"show\");
                return false;
            }
            return true;
        }
    </script>

    {# ==================================================================== #}
       <div class=\"modal fade\" id=\"myModal\">
            <div class=\"modal-dialog modal-lg modal-dialog-centered \" role=\"document\">
                <div class=\"modal-content \">
                    <div class=\"modal-header text-danger\">
                        <h4 class=\"modal-title \">Notification</h4>
                        <button aria-label=\"Close\" class=\"close\" data-dismiss=\"modal\" type=\"button\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">
                        <p id = \"message\"></p>
                    </div>
                    <div class=\"modal-footer\">
                        <button class=\"btn btn-secondary mx-auto\" data-dismiss=\"modal\" type=\"button\">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
    {# ==================================================================== #}

    <body class=\"body-Login-back\">
        <div class=\"container\">

            <div class=\"row\">
                <div class=\"col-md-4 col-md-offset-4 text-center logo-margin \">
                    <img alt=\"\" src=\"/assets/img/logo_new.png\"/>
                </div>
                <div class=\"col-md-4 col-md-offset-4\">
                    <div class=\"login-panel panel panel-default\">
                        <div class=\"panel-heading\">
                            <h3 class=\"panel-title\">Please, Sign Up</h3>
                        </div>
                        <div class=\"panel-body\">
                            <form  onsubmit=\"return formCheck(this)\">

                                <div class=\"form-group\">
                                    <label>Email address</label><br>
                                    <input autofocus class=\"form-control\" id=\"e_mail\" name=\"e_mail\" onchange=\"checkEmailForm();\" placeholder=\"E-mail\" type=\"email\">
                                    <div id=\"divCheckEmailForm\"></div>
                                    <br>
                                        <label>Password</label>
                                    </br>
                                    <input class=\"form-control\" id=\"password\" name=\"password\" placeholder=\"Password\" type=\"password\" value=\"\">
                                    <div id=\"divCheckPasswordForm\"></div>

                                    <br><label>Confirm Password</label>
                                    <input class=\"form-control\" id=\"confirm_password\" name=\"confirm_password\" onchange=\"checkPasswordMatch();\" placeholder=\"Confirm password\" type=\"password\" value=\"\"/>
                                    <div id=\"divCheckPasswordMatch\"></div>
                                    <br>
                                        <label>First Name</label>
                                    </br>
                                    <input class=\"form-control\" id=\"first_name\" name=\"first_name\" placeholder=\"First Name\" type=\"text\" value=\"\"></br>
                                <label>Last Name</label>
                            </br>
                            <input class=\"form-control\" id=\"last_name\" name=\"last_name\" placeholder=\"Last Name\" type=\"text\" value=\"\">
                        </div>
                        <label>Birth Date</label>
                    </br>
                    <input class=\"form-control\" id=\"birth_date\" name=\"birth_date\" placeholder=\"Birth Date\" type=\"date\" value=\"\"></br>
            </body>
        </html>
    </div>
    <!-- Change this to a button or input when using this as a form -->

    <div class=\"row text-center\" style=\"width: 100%\">
                    <a class=\"btn  btn-success\" href=\"/user/signin\">CANCEL</a>
                    <input class=\"btn  btn-success\" id=\"clicksignup\"type=\"submit\" value=\"COMPLETE\"/>
        </dev>
    </div>
</fieldset></form></div></div></div></div></div></div><!-- Core Scripts - Include with every page --><script src=\"/assets/plugins/jquery-1.10.2.js\"></script><script src=\"/assets/plugins/bootstrap/bootstrap.min.js\"></script><script src=\"/assets/plugins/metisMenu/jquery.metisMenu.js\"></script></body></html>

", "signup.twig", "/Users/eunkkk/IdeaProjects/QI_D_team/your-app/app/templates/signup.twig");
    }
}
