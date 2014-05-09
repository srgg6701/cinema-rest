<?php
$location = explode("/",$_SERVER['REQUEST_URI']);
// распарсить URL на сементы подключения файлов
$segments = array();
foreach(range(0,count($location)-1) as $index) { // /site_name/segment1/segment2/segment3
    if(isset($location[$index])&&$location[$index])
        $segments[$index-1]=$location[$index];
}