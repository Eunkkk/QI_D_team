<?php

/* signup.twig */
class __TwigTemplate_2e97d39ff38a5bf88a501aba3429dfde1f7926d1342e0c43edeb8498bc618efa extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>

<head>
  <meta charset=\"utf-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title>QI Team D Sign Un Page</title>
  <!-- Core CSS - Include with every page -->
  <link href=\"/assets/plugins/bootstrap/bootstrap.css\" rel=\"stylesheet\" />
  <link href=\"/assets/font-awesome//css/font-awesome.css\" rel=\"stylesheet\" />
  <link href=\"/assets/plugins/pace/pace-theme-big-counter.css\" rel=\"stylesheet\" />
  <link href=\"/assets//css/style.css\" rel=\"stylesheet\" />
  <link href=\"/assets//css/main-style.css\" rel=\"stylesheet\" />

</head>
<script type=\"text/javascript\">
  var count = 0;
  // function Check() {
  //
  //   if (count == 0) {
  //     var div = document.createElement('div');
  //     div.innerHTML = document.getElementById('after_duplicate_check').innerHTML;
  //     document.getElementById('field').appendChild(div);
  //     count = 1;
  //   }
  // }
</script>

<body class=\"body-Login-back\">

  <div class=\"container\">

    <div class=\"row\">
      <div class=\"col-md-4 col-md-offset-4 text-center logo-margin \">
        <img src=\"/assets/img/logo_new.png\" alt=\"\" />
      </div>
      <div class=\"col-md-4 col-md-offset-4\">
        <div class=\"login-panel panel panel-default\">
          <div class=\"panel-heading\">
            <h3 class=\"panel-title\">Please Sign Up</h3>
          </div>
          <div class=\"panel-body\">
            <form action=\"/user/signup/request\" method=\"post\">
              <div class=\"form-group\">
                <label>Email address</label></br>
                <input class=\"form-control\" placeholder=\"E-mail\" name=\"e_mail\" type=\"email\" autofocus></br>
                <label>Password</label></br>
                <input class=\"form-control\" placeholder=\"Password\" name=\"password\" type=\"password\" value=\"\"></br>
                <div>
                  <label>First Name</label></br>
                  <input class=\"form-control\" placeholder=\"First Name\" name=\"first_name\" type=\"text\" value=\"\"></br>
                  <label>Last Name</label></br>
                  <input class=\"form-control\" placeholder=\"Last Name\" name=\"last_name\" type=\"text\" value=\"\"></br>
                </div>
                <label>Birth Date</label></br>
                <input class=\"form-control\" placeholder=\"Birth Date\" name=\"birth_date\" type=\"date\" value=\"\"></br>
              </div>
              <!-- Change this to a button or input when using this as a form -->
              <button  class=\"btn btn-lg btn-success btn-block\" type=\"submit\">Sign up</button>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Core Scripts - Include with every page -->
  <script src=\"/assets/plugins/jquery-1.10.2.js\"></script>
  <script src=\"/assets/plugins/bootstrap/bootstrap.min.js\"></script>
  <script src=\"/assets/plugins/metisMenu/jquery.metisMenu.js\"></script>

</body>

</html>
";
    }

    public function getTemplateName()
    {
        return "signup.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html>*/
/* */
/* <head>*/
/*   <meta charset="utf-8">*/
/*   <meta name="viewport" content="width=device-width, initial-scale=1.0">*/
/*   <title>QI Team D Sign Un Page</title>*/
/*   <!-- Core CSS - Include with every page -->*/
/*   <link href="/assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />*/
/*   <link href="/assets/font-awesome//css/font-awesome.css" rel="stylesheet" />*/
/*   <link href="/assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />*/
/*   <link href="/assets//css/style.css" rel="stylesheet" />*/
/*   <link href="/assets//css/main-style.css" rel="stylesheet" />*/
/* */
/* </head>*/
/* <script type="text/javascript">*/
/*   var count = 0;*/
/*   // function Check() {*/
/*   //*/
/*   //   if (count == 0) {*/
/*   //     var div = document.createElement('div');*/
/*   //     div.innerHTML = document.getElementById('after_duplicate_check').innerHTML;*/
/*   //     document.getElementById('field').appendChild(div);*/
/*   //     count = 1;*/
/*   //   }*/
/*   // }*/
/* </script>*/
/* */
/* <body class="body-Login-back">*/
/* */
/*   <div class="container">*/
/* */
/*     <div class="row">*/
/*       <div class="col-md-4 col-md-offset-4 text-center logo-margin ">*/
/*         <img src="/assets/img/logo_new.png" alt="" />*/
/*       </div>*/
/*       <div class="col-md-4 col-md-offset-4">*/
/*         <div class="login-panel panel panel-default">*/
/*           <div class="panel-heading">*/
/*             <h3 class="panel-title">Please Sign Up</h3>*/
/*           </div>*/
/*           <div class="panel-body">*/
/*             <form action="/user/signup/request" method="post">*/
/*               <div class="form-group">*/
/*                 <label>Email address</label></br>*/
/*                 <input class="form-control" placeholder="E-mail" name="e_mail" type="email" autofocus></br>*/
/*                 <label>Password</label></br>*/
/*                 <input class="form-control" placeholder="Password" name="password" type="password" value=""></br>*/
/*                 <div>*/
/*                   <label>First Name</label></br>*/
/*                   <input class="form-control" placeholder="First Name" name="first_name" type="text" value=""></br>*/
/*                   <label>Last Name</label></br>*/
/*                   <input class="form-control" placeholder="Last Name" name="last_name" type="text" value=""></br>*/
/*                 </div>*/
/*                 <label>Birth Date</label></br>*/
/*                 <input class="form-control" placeholder="Birth Date" name="birth_date" type="date" value=""></br>*/
/*               </div>*/
/*               <!-- Change this to a button or input when using this as a form -->*/
/*               <button  class="btn btn-lg btn-success btn-block" type="submit">Sign up</button>*/
/*               </fieldset>*/
/*             </form>*/
/*           </div>*/
/*         </div>*/
/*       </div>*/
/*     </div>*/
/*   </div>*/
/* */
/*   <!-- Core Scripts - Include with every page -->*/
/*   <script src="/assets/plugins/jquery-1.10.2.js"></script>*/
/*   <script src="/assets/plugins/bootstrap/bootstrap.min.js"></script>*/
/*   <script src="/assets/plugins/metisMenu/jquery.metisMenu.js"></script>*/
/* */
/* </body>*/
/* */
/* </html>*/
/* */
