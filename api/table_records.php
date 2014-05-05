<?php
if($_SERVER['REQUEST_METHOD']!='POST')
    die('Ты куда собрался, Малыш? Сюда можно ходить только методом POST!');
$query = "INSERT INTO ";
var_dump("<pre>",$_POST,"<pre/>"); die();
