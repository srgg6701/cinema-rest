<?php
error_reporting(E_ALL);
session_start();
$_SESSION['active_user_id']=$_GET['user_id'];
echo $_SESSION['active_user_id'];
exit;
