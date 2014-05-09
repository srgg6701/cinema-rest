<?php
error_reporting(E_ALL);
session_start();
$_SESSION['active_user_id']=$_GET['user_id'];
echo "<pre>user_id = ".$_GET['user_id']."</pre>";
var_dump("<pre>",$_SESSION,"<pre/>");
echo $_SESSION['active_user_id']; 
die();
