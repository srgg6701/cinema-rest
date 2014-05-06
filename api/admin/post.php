<?php
if($_SERVER['REQUEST_METHOD']!='POST')
    die('Ты куда собрался, Малыш? Сюда можно ходить только методом POST!');
$query = "INSERT INTO $_POST[table] (";
$fields=$values=array();
foreach($_POST as $key => $val){
    if($key!=='table'){
        if($key=='showtime')
            $val.=" ".$_POST['time'].":00";
        if($key!='time'){
            $fields[]=$key;
            $values[]=$val;
        }
    }
}
$query.="`" . implode("`, `",$fields) . "`) VALUES (";
$query.="'" . implode("', '",$values) . "')";
var_dump("<pre>",$_POST,"<pre/>");
var_dump($query); die();
