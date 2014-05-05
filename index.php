<?php

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/.css">
        <script src="/.js"></script>
<!-- move styles to a separated file -->
<style>
html, body{
	height:100%;
	margin:0;
	padding:0;
}
#nav, main, #footer{
	margin:auto !important;
	max-width:90%;
	min-width:640px;
}
#container *{
	box-sizing:border-box;
}
.offsetVertical10,
section{
	padding-top:10px;
	padding-bottom:10px;
}
nav{
	margin:auto -10px;
	padding:10px;
}
footer{
	background-color:#efefef;
}
#footer{
	height:60px;
	line-height:60px;
	padding:0 10px;
}
#main{
	min-height:100%;
	margin-bottom:-60px;
	padding:0 10px 60px;
}
nav{
	background-color: #eaebec;
}
</style>
    </head>
    <body>
    	<div id="container">
        	<div id="main">
            	<nav>
                	<div id="nav">Navigation</div>
                </nav>
                <main>
                	<section>
                		Main content
                    </section>
                </main>
            </div>
            <footer>
            	<div id="footer">Footer</div>
            </footer>
        </div>
    </body>
</html>
