<?php
$location = explode("/",$_SERVER['REQUEST_URI']);
// распарсить URL на сементы подключения файлов
$segments = array();
foreach(range(1,count($location)-1) as $index) { // /site_name/segment1/segment2/segment3
    isset($location[$index])? :$segments[$index]=$location[$index];
}