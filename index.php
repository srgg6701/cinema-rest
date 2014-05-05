<?php	require "router.php"; 

$content = ob_get_contents();
ob_end_clean();

?><!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link  media="screen, projection" rel="stylesheet" type="text/css" href="static/stylesheets/screen.css">
        <script src="static/jquery/dist/jquery.min.js"></script>
        <script src="static/js/common.js"></script>
    </head>
    <body>
    	<div id="container">
        	<div id="main">
            	<nav class="clearfix">
                	<div id="nav"><a class="floatLeft" href="<?php
                    echo SITE_ROOT;
					?>">Главная</a>
                    	<div class="floatRight">
                        	<a href="/?user_type=admin">Админ</a> | <a href="/?user_type=spectator">Зритель</a>
                        </div>
                    </div>                    
                </nav>
                <main>
                	<section>
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
