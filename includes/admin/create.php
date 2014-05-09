<?php
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['REQUEST_METHOD']!='POST')
    die('Ты куда собрался, Малыш? Сюда можно ходить только методом POST!');

require_once '../routing/path.php';
require_once FILES_ROOT."includes/functions/cud/cud.php";
// добавляем запись
createRecord($_POST);
// go home
header("location:".SITE_ROOT.'admin/'.$_POST['table']);

