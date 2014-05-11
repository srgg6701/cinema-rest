<?php
$location = explode("/",$_SERVER['REQUEST_URI']);
$project_name = 'cinema-rest';
if(!in_array($project_name,$location))
    die("<b style='color:red'>Имя проекта установлено неправильно!</b>
    <br>Это может привести к ошибке роутинга.");
else{ // скорректировать путь в зависимости от структуры файловой системы сервера:
    $location_index_plus = array_search($project_name,$location)-1;
}
// распарсить URL на сементы подключения файлов
$segments = array();
foreach(range(0,count($location)-1) as $index) { // /site_name/segment1/segment2/segment3
    if(isset($location[$index+$location_index_plus])
             && $location[$index+$location_index_plus] )
        $segments[$index-1]=$location[$index+$location_index_plus];
}