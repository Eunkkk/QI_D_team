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

/* index.twig */
class __TwigTemplate_5ed140f5976b948be50ab26e509548003aa4fbc6dd58334d83c5ae5613507344 extends \Twig\Template
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
<html lang=\"en\">

    <head>

        <meta charset=\"utf-8\">
        <meta content=\"width=device-width, initial-scale=1, shrink-to-fit=no\" name=\"viewport\">
        <meta content=\"\" name=\"description\">
        <meta content=\"\" name=\"author\">

        <title>Your Fresh Route</title>

        <!-- Bootstrap core CSS -->
        <link
        href=\"vendor/bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\">

        <!-- Custom styles for this template -->
        <link href=\"css/modern-business.css\" rel=\"stylesheet\">
        
    </head>
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>
    <script type=\"text/javascript\">
    function CheckLoginState() {
      var getUSN = localStorage.getItem('USN');
        if (getUSN === null){
          var link = document.getElementById('link_1');
          link.setAttribute('href', \"/user/signin\");
          link.innerHTML = \"Sign-In\";
          var link2 = document.getElementById('link_2');
          link2.setAttribute('href', \"/user/signup\");
          link2.innerHTML = \"Sign-Up\";

        } else{
          var link = document.getElementById('link_1');
           link.setAttribute('href', \"/user/index\");
           link.innerHTML =  \"User Page\"
        }
    }
    </script>

    <body onload=\"CheckLoginState();\">

        <!-- Navigation -->
        <!-- <nav class=\"navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top\"> -->
            <nav class=\"navbar fixed-top navbar-expand-lg navbar-light fixed-top\" style=\"background-color: #84b899;\"> <div class=\"container\">
                <a class=\"navbar-brand\" href=\"index.html\">Team D
                </a>
                <button aria-controls=\"navbarResponsive\" aria-expanded=\"false\" aria-label=\"Toggle navigation\" class=\"navbar-toggler navbar-toggler-right\" data-target=\"#navbarResponsive\" data-toggle=\"collapse\" type=\"button\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
                <div class=\"collapse navbar-collapse\" id=\"navbarResponsive\">
                    <ul class=\"navbar-nav ml-auto\">
                        <li class=\"nav-item\">
                            <a class=\"nav-link\" id=\"link_2\" href=\"\"></a>
                        </li>
                        <li class=\"nav-item\">
                            <a class=\"nav-link\" id=\"link_1\" href=\"\"></a>
                        </li>
                        <!-- <li class=\"nav-item\">
                                    <a class=\"nav-link\" href=\"Logout.twig\">Logout</a>
                                  </li> -->
                        <!-- <li class=\"nav-item dropdown\">
                                    <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownPortfolio\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                      Portfolio
                                    </a>
                                    <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdownPortfolio\">
                                      <a class=\"dropdown-item\" href=\"portfolio-1-col.html\">1 Column Portfolio</a>
                                      <a class=\"dropdown-item\" href=\"portfolio-2-col.html\">2 Column Portfolio</a>
                                      <a class=\"dropdown-item\" href=\"portfolio-3-col.html\">3 Column Portfolio</a>
                                      <a class=\"dropdown-item\" href=\"portfolio-4-col.html\">4 Column Portfolio</a>
                                      <a class=\"dropdown-item\" href=\"portfolio-item.html\">Single Portfolio Item</a>
                                    </div>
                                  </li>
                                  <li class=\"nav-item dropdown\">
                                    <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownBlog\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                      Blog
                                    </a>
                                    <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdownBlog\">
                                      <a class=\"dropdown-item\" href=\"blog-home-1.html\">Blog Home 1</a>
                                      <a class=\"dropdown-item\" href=\"blog-home-2.html\">Blog Home 2</a>
                                      <a class=\"dropdown-item\" href=\"blog-post.html\">Blog Post</a>
                                    </div>
                                  </li>
                                  <li class=\"nav-item dropdown\">
                                    <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownBlog\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                      Other Pages
                                    </a>
                                    <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdownBlog\">
                                      <a class=\"dropdown-item\" href=\"full-width.html\">Full Width Page</a>
                                      <a class=\"dropdown-item\" href=\"sidebar.html\">Sidebar Page</a>
                                      <a class=\"dropdown-item\" href=\"faq.html\">FAQ</a>
                                      <a class=\"dropdown-item\" href=\"404.html\">404</a>
                                      <a class=\"dropdown-item\" href=\"pricing.html\">Pricing Table</a>
                                    </div>
                                  </li> -->
                    </ul>
                </div>
            </div>
        </nav>

        <header>
            <div class=\"carousel slide\" data-ride=\"carousel\" id=\"carouselExampleIndicators\">
                <ol class=\"carousel-indicators\">
                    <li class=\"active\" data-slide-to=\"0\" data-target=\"#carouselExampleIndicators\"></li>
                    <li data-slide-to=\"1\" data-target=\"#carouselExampleIndicators\"></li>
                    <li data-slide-to=\"2\" data-target=\"#carouselExampleIndicators\"></li>
                </ol>
                <div
                    class=\"carousel-inner\" role=\"listbox\">
                    <!-- Slide One - Set the background image for this slide in the line below -->
                    <div class=\"carousel-item active\" style=\"background-image: url('https://justwallpapers.files.wordpress.com/2012/11/autumn-colors.jpg')\">
                        <div class=\"carousel-caption d-none d-md-block\">
                            <h3>Find your Fresh Route.</h3>
                            <p>The data measured by the sensor tells you if your route is safe or not..</p>
                        </div>
                    </div>
                    <!-- Slide Two - Set the background image for this slide in the line below -->
                    <div class=\"carousel-item\" style=\"background-image: url('https://www.foreverwallpapers.com/wp-content/uploads/2018/08/sky-1900x1080.jpg')\">
                        <div class=\"carousel-caption d-none d-md-block\">
                            <h3>Find your Fresh Route.</h3>
                            <p>The data measured by the sensor tells you if your route is safe or not..</p>
                        </div>
                    </div>
                    <!-- Slide Three - Set the background image for this slide in the line below -->
                    <div class=\"carousel-item\" style=\"background-image: url('http://www.do-it-every-day.com/assets/running-1900x1080-60-338d6f68d36c77a66346ec5557d71fc6bddc76929ecdbb96cb9c721db07cb908.jpg')\">
                        <div class=\"carousel-caption d-none d-md-block\">
                            <h3>Find your Fresh Route.</h3>
                            <p>The data measured by the sensor tells you if your route is safe or not..</p>
                        </div>
                    </div>
                </div>
                <a class=\"carousel-control-prev\" data-slide=\"prev\" href=\"#carouselExampleIndicators\" role=\"button\">
                    <span aria-hidden=\"true\" class=\"carousel-control-prev-icon\"></span>
                    <span class=\"sr-only\">Previous</span>
                </a>
                <a class=\"carousel-control-next\" data-slide=\"next\" href=\"#carouselExampleIndicators\" role=\"button\">
                    <span aria-hidden=\"true\" class=\"carousel-control-next-icon\"></span>
                    <span class=\"sr-only\">Next</span>
                </a>
            </div>
        </header>

        <!-- Page Content -->
        <div class=\"container\">

            <h1 class=\"my-4\">The contents of our's application will be entered in here</h1>

            <!-- Marketing Icons Section -->
            <div class=\"row\">
                <div class=\"col-lg-4 mb-4\">
                    <div class=\"card h-100\">
                        <h4 class=\"card-header\">Card title1</h4>
                        <div class=\"card-body\">
                            <p class=\"card-text\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
                        </div>
                        <div class=\"card-footer\">
                            <a class=\"btn btn-primary\" href=\"#\">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class=\"col-lg-4 mb-4\">
                    <div class=\"card h-100\">
                        <h4 class=\"card-header\">Card title2</h4>
                        <div class=\"card-body\">
                            <p class=\"card-text\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis ipsam eos, nam perspiciatis natus commodi similique totam consectetur praesentium molestiae atque exercitationem ut consequuntur, sed eveniet, magni nostrum sint fuga.</p>
                        </div>
                        <div class=\"card-footer\">
                            <a class=\"btn btn-primary\" href=\"#\">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class=\"col-lg-4 mb-4\">
                    <div class=\"card h-100\">
                        <h4 class=\"card-header\">Card title3</h4>
                        <div class=\"card-body\">
                            <p class=\"card-text\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
                        </div>
                        <div class=\"card-footer\">
                            <a class=\"btn btn-primary\" href=\"#\">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Portfolio Section -->
         

            <!-- Features Section -->
                <div class=\"row\"> <div class=\"col-lg-6\">
                    <h2>Features</h2>
                    <p>Our's application includes:</p>
                    <ul>
                        <li>
                            <strong>Bootstrap v4</strong>
                        </li>
                        <li>nice</li>
                        <li>somthing cool</li>
                        \\
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, omnis doloremque non cum id reprehenderit, quisquam totam aspernatur tempora minima unde aliquid ea culpa sunt. Reiciendis quia dolorum ducimus unde.</p>
                </div>
                ";
        // line 206
        echo "            </div>
            <!-- /.row -->

            <hr>

            <!-- Call to Action Section -->
            <div class=\"row mb-4\">
                <div class=\"col-md-8\">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p>
                </div>
                <div class=\"col-md-4\">
                    <a class=\"btn btn-lg btn-secondary btn-block\" href=\"#\">Call to Action</a>
                </div>
            </div>

        </div>
        <!-- /.container -->

        <!-- Footer -->
        <footer class=\"py-5 bg-dark\">
            <div class=\"container\">
                <p class=\"m-0 text-center text-white\">Copyright &copy; Your Website 2019</p>
            </div>
            <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src=\"vendor/jquery/jquery.min.js\"></script>
        <script src=\"vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>

    </body>

</html>

";
    }

    public function getTemplateName()
    {
        return "index.twig";
    }

    public function getDebugInfo()
    {
        return array (  241 => 206,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">

    <head>

        <meta charset=\"utf-8\">
        <meta content=\"width=device-width, initial-scale=1, shrink-to-fit=no\" name=\"viewport\">
        <meta content=\"\" name=\"description\">
        <meta content=\"\" name=\"author\">

        <title>Your Fresh Route</title>

        <!-- Bootstrap core CSS -->
        <link
        href=\"vendor/bootstrap/css/bootstrap.min.css\" rel=\"stylesheet\">

        <!-- Custom styles for this template -->
        <link href=\"css/modern-business.css\" rel=\"stylesheet\">
        
    </head>
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>
    <script type=\"text/javascript\">
    function CheckLoginState() {
      var getUSN = localStorage.getItem('USN');
        if (getUSN === null){
          var link = document.getElementById('link_1');
          link.setAttribute('href', \"/user/signin\");
          link.innerHTML = \"Sign-In\";
          var link2 = document.getElementById('link_2');
          link2.setAttribute('href', \"/user/signup\");
          link2.innerHTML = \"Sign-Up\";

        } else{
          var link = document.getElementById('link_1');
           link.setAttribute('href', \"/user/index\");
           link.innerHTML =  \"User Page\"
        }
    }
    </script>

    <body onload=\"CheckLoginState();\">

        <!-- Navigation -->
        <!-- <nav class=\"navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top\"> -->
            <nav class=\"navbar fixed-top navbar-expand-lg navbar-light fixed-top\" style=\"background-color: #84b899;\"> <div class=\"container\">
                <a class=\"navbar-brand\" href=\"index.html\">Team D
                </a>
                <button aria-controls=\"navbarResponsive\" aria-expanded=\"false\" aria-label=\"Toggle navigation\" class=\"navbar-toggler navbar-toggler-right\" data-target=\"#navbarResponsive\" data-toggle=\"collapse\" type=\"button\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
                <div class=\"collapse navbar-collapse\" id=\"navbarResponsive\">
                    <ul class=\"navbar-nav ml-auto\">
                        <li class=\"nav-item\">
                            <a class=\"nav-link\" id=\"link_2\" href=\"\"></a>
                        </li>
                        <li class=\"nav-item\">
                            <a class=\"nav-link\" id=\"link_1\" href=\"\"></a>
                        </li>
                        <!-- <li class=\"nav-item\">
                                    <a class=\"nav-link\" href=\"Logout.twig\">Logout</a>
                                  </li> -->
                        <!-- <li class=\"nav-item dropdown\">
                                    <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownPortfolio\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                      Portfolio
                                    </a>
                                    <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdownPortfolio\">
                                      <a class=\"dropdown-item\" href=\"portfolio-1-col.html\">1 Column Portfolio</a>
                                      <a class=\"dropdown-item\" href=\"portfolio-2-col.html\">2 Column Portfolio</a>
                                      <a class=\"dropdown-item\" href=\"portfolio-3-col.html\">3 Column Portfolio</a>
                                      <a class=\"dropdown-item\" href=\"portfolio-4-col.html\">4 Column Portfolio</a>
                                      <a class=\"dropdown-item\" href=\"portfolio-item.html\">Single Portfolio Item</a>
                                    </div>
                                  </li>
                                  <li class=\"nav-item dropdown\">
                                    <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownBlog\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                      Blog
                                    </a>
                                    <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdownBlog\">
                                      <a class=\"dropdown-item\" href=\"blog-home-1.html\">Blog Home 1</a>
                                      <a class=\"dropdown-item\" href=\"blog-home-2.html\">Blog Home 2</a>
                                      <a class=\"dropdown-item\" href=\"blog-post.html\">Blog Post</a>
                                    </div>
                                  </li>
                                  <li class=\"nav-item dropdown\">
                                    <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownBlog\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                      Other Pages
                                    </a>
                                    <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdownBlog\">
                                      <a class=\"dropdown-item\" href=\"full-width.html\">Full Width Page</a>
                                      <a class=\"dropdown-item\" href=\"sidebar.html\">Sidebar Page</a>
                                      <a class=\"dropdown-item\" href=\"faq.html\">FAQ</a>
                                      <a class=\"dropdown-item\" href=\"404.html\">404</a>
                                      <a class=\"dropdown-item\" href=\"pricing.html\">Pricing Table</a>
                                    </div>
                                  </li> -->
                    </ul>
                </div>
            </div>
        </nav>

        <header>
            <div class=\"carousel slide\" data-ride=\"carousel\" id=\"carouselExampleIndicators\">
                <ol class=\"carousel-indicators\">
                    <li class=\"active\" data-slide-to=\"0\" data-target=\"#carouselExampleIndicators\"></li>
                    <li data-slide-to=\"1\" data-target=\"#carouselExampleIndicators\"></li>
                    <li data-slide-to=\"2\" data-target=\"#carouselExampleIndicators\"></li>
                </ol>
                <div
                    class=\"carousel-inner\" role=\"listbox\">
                    <!-- Slide One - Set the background image for this slide in the line below -->
                    <div class=\"carousel-item active\" style=\"background-image: url('https://justwallpapers.files.wordpress.com/2012/11/autumn-colors.jpg')\">
                        <div class=\"carousel-caption d-none d-md-block\">
                            <h3>Find your Fresh Route.</h3>
                            <p>The data measured by the sensor tells you if your route is safe or not..</p>
                        </div>
                    </div>
                    <!-- Slide Two - Set the background image for this slide in the line below -->
                    <div class=\"carousel-item\" style=\"background-image: url('https://www.foreverwallpapers.com/wp-content/uploads/2018/08/sky-1900x1080.jpg')\">
                        <div class=\"carousel-caption d-none d-md-block\">
                            <h3>Find your Fresh Route.</h3>
                            <p>The data measured by the sensor tells you if your route is safe or not..</p>
                        </div>
                    </div>
                    <!-- Slide Three - Set the background image for this slide in the line below -->
                    <div class=\"carousel-item\" style=\"background-image: url('http://www.do-it-every-day.com/assets/running-1900x1080-60-338d6f68d36c77a66346ec5557d71fc6bddc76929ecdbb96cb9c721db07cb908.jpg')\">
                        <div class=\"carousel-caption d-none d-md-block\">
                            <h3>Find your Fresh Route.</h3>
                            <p>The data measured by the sensor tells you if your route is safe or not..</p>
                        </div>
                    </div>
                </div>
                <a class=\"carousel-control-prev\" data-slide=\"prev\" href=\"#carouselExampleIndicators\" role=\"button\">
                    <span aria-hidden=\"true\" class=\"carousel-control-prev-icon\"></span>
                    <span class=\"sr-only\">Previous</span>
                </a>
                <a class=\"carousel-control-next\" data-slide=\"next\" href=\"#carouselExampleIndicators\" role=\"button\">
                    <span aria-hidden=\"true\" class=\"carousel-control-next-icon\"></span>
                    <span class=\"sr-only\">Next</span>
                </a>
            </div>
        </header>

        <!-- Page Content -->
        <div class=\"container\">

            <h1 class=\"my-4\">The contents of our's application will be entered in here</h1>

            <!-- Marketing Icons Section -->
            <div class=\"row\">
                <div class=\"col-lg-4 mb-4\">
                    <div class=\"card h-100\">
                        <h4 class=\"card-header\">Card title1</h4>
                        <div class=\"card-body\">
                            <p class=\"card-text\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
                        </div>
                        <div class=\"card-footer\">
                            <a class=\"btn btn-primary\" href=\"#\">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class=\"col-lg-4 mb-4\">
                    <div class=\"card h-100\">
                        <h4 class=\"card-header\">Card title2</h4>
                        <div class=\"card-body\">
                            <p class=\"card-text\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis ipsam eos, nam perspiciatis natus commodi similique totam consectetur praesentium molestiae atque exercitationem ut consequuntur, sed eveniet, magni nostrum sint fuga.</p>
                        </div>
                        <div class=\"card-footer\">
                            <a class=\"btn btn-primary\" href=\"#\">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class=\"col-lg-4 mb-4\">
                    <div class=\"card h-100\">
                        <h4 class=\"card-header\">Card title3</h4>
                        <div class=\"card-body\">
                            <p class=\"card-text\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
                        </div>
                        <div class=\"card-footer\">
                            <a class=\"btn btn-primary\" href=\"#\">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Portfolio Section -->
         

            <!-- Features Section -->
                <div class=\"row\"> <div class=\"col-lg-6\">
                    <h2>Features</h2>
                    <p>Our's application includes:</p>
                    <ul>
                        <li>
                            <strong>Bootstrap v4</strong>
                        </li>
                        <li>nice</li>
                        <li>somthing cool</li>
                        \\
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, omnis doloremque non cum id reprehenderit, quisquam totam aspernatur tempora minima unde aliquid ea culpa sunt. Reiciendis quia dolorum ducimus unde.</p>
                </div>
                {# <div class=\"col-lg-6\">
                        <img class=\"img-fluid rounded\" src=\"http://placehold.it/700x450\" alt=\"\">
                      </div> #}
            </div>
            <!-- /.row -->

            <hr>

            <!-- Call to Action Section -->
            <div class=\"row mb-4\">
                <div class=\"col-md-8\">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p>
                </div>
                <div class=\"col-md-4\">
                    <a class=\"btn btn-lg btn-secondary btn-block\" href=\"#\">Call to Action</a>
                </div>
            </div>

        </div>
        <!-- /.container -->

        <!-- Footer -->
        <footer class=\"py-5 bg-dark\">
            <div class=\"container\">
                <p class=\"m-0 text-center text-white\">Copyright &copy; Your Website 2019</p>
            </div>
            <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src=\"vendor/jquery/jquery.min.js\"></script>
        <script src=\"vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>

    </body>

</html>

", "index.twig", "/Users/eunkkk/IdeaProjects/QI_D_team/your-app/app/templates/index.twig");
    }
}
