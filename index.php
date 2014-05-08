<?php	//echo __FILE__."<hr>";
error_reporting(E_ALL); //E_ERROR | E_WARNING
header('Content-Type: text/html; charset=utf-8');

require "includes/routing/router.php"; 

$content = ob_get_contents();
ob_end_clean();

?><!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>We love Cinema! &copy;</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link  media="screen, projection" rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT;?>static/stylesheets/screen.css">
        <script src="<?php echo SITE_ROOT;?>static/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo SITE_ROOT;?>static/js/common.js"></script>
    </head>
    <body>
    	<div id="container">
        	<div id="main">
            	<nav class="clearfix">
                	<div id="nav"><a class="floatLeft" href="<?php
                    echo SITE_ROOT;
					?>">Главная</a>                    	
                    </div>                    
                </nav>
                <main>
                	<section class="clearfix">
                		<?php echo $content;?>
                    </section>
                </main>
            </div>
            <footer>
            	<div id="footer"><a href="<?php
                    echo SITE_ROOT;
					?>">Главная</a></div>
            </footer>
        </div>
    </body>
</html>
