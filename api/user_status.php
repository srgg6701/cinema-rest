<?php session_start();
$_SESSION['user_type']=$_GET['role'];
echo $_SESSION['user_type'];