<?php

/* signin.twig */
class __TwigTemplate_cb31f2a23353038e78f02c648f2ae5d865265b94bf4c4b382b59d454f30b25fc extends Twig_Template
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
    <title>QI Team D Sign In Page</title>
    <!-- Core CSS - Include with every page -->
    <link href=\"/assets/plugins/bootstrap/bootstrap.css\" rel=\"stylesheet\" />
    <link href=\"/assets/font-awesome//css/font-awesome.css\" rel=\"stylesheet\" />
    <link href=\"/assets/plugins/pace/pace-theme-big-counter.css\" rel=\"stylesheet\" />
   <link href=\"/assets//css/style.css\" rel=\"stylesheet\" />
      <link href=\"/assets//css/main-style.css\" rel=\"stylesheet\" />

</head>

<body class=\"body-Login-back\">

    <div class=\"container\">

        <div class=\"row\">
            <div class=\"col-md-4 col-md-offset-4 text-center logo-margin \">
              <img src=\"/assets/img/logo_new.png\" alt=\"\"/>
                </div>
            <div class=\"col-md-4 col-md-offset-4\">
                <div class=\"login-panel panel panel-default\">
                    <div class=\"panel-heading\">
                        <h3 class=\"panel-title\">Please Sign In</h3>
                    </div>
                    <div class=\"panel-body\">
                        <form action=\"/user/signin/request\" method=\"post\">
                            <fieldset>
                                <div class=\"form-group\">
                                    <input class=\"form-control\" placeholder=\"E-mail\" name=\"e_mail\" type=\"email\" autofocus>
                                </div>
                                <div class=\"form-group\">
                                    <input class=\"form-control\" placeholder=\"Password\" name=\"password\" type=\"password\" value=\"\">
                                </div>
                                <div>
                                  <a  href=\"fpwchange\"> Forgot Your Pssword?</a></br>
                                  <a href=\"signup\" >New here? Sign up!</a></br></br>
                                </div>
                                <button class=\"btn btn-lg btn-success btn-block \" type=\"submit\">Login</button>
                            </fieldset>
                        </form>


                        </br></a>
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
        return "signin.twig";
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
/*     <meta name="viewport" content="width=device-width, initial-scale=1.0">*/
/*     <title>QI Team D Sign In Page</title>*/
/*     <!-- Core CSS - Include with every page -->*/
/*     <link href="/assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />*/
/*     <link href="/assets/font-awesome//css/font-awesome.css" rel="stylesheet" />*/
/*     <link href="/assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />*/
/*    <link href="/assets//css/style.css" rel="stylesheet" />*/
/*       <link href="/assets//css/main-style.css" rel="stylesheet" />*/
/* */
/* </head>*/
/* */
/* <body class="body-Login-back">*/
/* */
/*     <div class="container">*/
/* */
/*         <div class="row">*/
/*             <div class="col-md-4 col-md-offset-4 text-center logo-margin ">*/
/*               <img src="/assets/img/logo_new.png" alt=""/>*/
/*                 </div>*/
/*             <div class="col-md-4 col-md-offset-4">*/
/*                 <div class="login-panel panel panel-default">*/
/*                     <div class="panel-heading">*/
/*                         <h3 class="panel-title">Please Sign In</h3>*/
/*                     </div>*/
/*                     <div class="panel-body">*/
/*                         <form action="/user/signin/request" method="post">*/
/*                             <fieldset>*/
/*                                 <div class="form-group">*/
/*                                     <input class="form-control" placeholder="E-mail" name="e_mail" type="email" autofocus>*/
/*                                 </div>*/
/*                                 <div class="form-group">*/
/*                                     <input class="form-control" placeholder="Password" name="password" type="password" value="">*/
/*                                 </div>*/
/*                                 <div>*/
/*                                   <a  href="fpwchange"> Forgot Your Pssword?</a></br>*/
/*                                   <a href="signup" >New here? Sign up!</a></br></br>*/
/*                                 </div>*/
/*                                 <button class="btn btn-lg btn-success btn-block " type="submit">Login</button>*/
/*                             </fieldset>*/
/*                         </form>*/
/* */
/* */
/*                         </br></a>*/
/*                     </div>*/
/*                 </div>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/* */
/*      <!-- Core Scripts - Include with every page -->*/
/*     <script src="/assets/plugins/jquery-1.10.2.js"></script>*/
/*     <script src="/assets/plugins/bootstrap/bootstrap.min.js"></script>*/
/*     <script src="/assets/plugins/metisMenu/jquery.metisMenu.js"></script>*/
/* */
/* </body>*/
/* */
/* </html>*/
/* */
