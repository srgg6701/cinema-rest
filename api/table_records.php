<?php
if($_SERVER['REQUEST_METHOD']!='POST')
    die('Ты куда собрался, Малыш? Сюда можно ходить только методом POST!');
$query = "INSERT INTO $_POST[table] (";
$fields=$values=array();
foreach($_POST as $key => $val){
    if($key!=='table'){
        $fields[]=$key;
        $values[]=$val;
        if($key=='showtime'){
            $key = 'datetime';
            $fields[]= $key;
            $values[]=date('Y-m-d H:i:s');
        }
    }
}
$query.="`" . implode("`,`",$fields) . "`) VALUES (";
$query.="'" . implode("','",$values) . "')";
var_dump("<pre>",$query,"<pre/>"); die();
