<?php session_start();
$location = mbsplit('/',$_SERVER['REQUEST_URI']);
// set root path
if(!defined('SITE_ROOT')){
    $common_path = 'http://'.$_SERVER['HTTP_HOST'];
    if($_SERVER['HTTP_HOST']=='127.0.0.1'||$_SERVER['HTTP_HOST']=='localhost')
        $common_path.='/'.$location[1];
    define('SITE_ROOT',$common_path.'/');
}

//$api_path=null;
//if(in_array('api',$location)) $api_path='';

// распарсить URL на сементы подключения файлов
$segments = array();
foreach(range(1,count($location)) as $index) { // /site_name/segment1/segment2/segment3
    $segments[$index-1]=(isset($location[$index]))? $location[$index]:NULL;
    //if($api_path!==null)
        //$api_path.'/'.$segments[$index-1];
}

require_once 'connect_db.php';

//if($api_path) {
    //require_once $api_path;
//}
// DOCUMENT_ROOT/имя сайта
$path_to_files = $_SERVER['DOCUMENT_ROOT'].'/'.$location[1].'/';
$path_to_template = $path_to_files.'templates/';
$path_to_files.='api/';

$action = mb_strtolower($_SERVER['REQUEST_METHOD']);
if(!$segments[1]){
    $path_to_template.= 'default';
}else{
    // модифицировать путь подключения файлов
    if($segments[2])
        // site_name/api/(admin|cinema|halls|movies|tickets)/
        $path_to_files.=$segments[2].'/';
    // подключить ресурс
    if($segments[3])
        // site_name/api/***/(delete|get|post|put)/
        $path_to_files.=$action.'/';
    if($segments[2]=='admin'){
        // будем подключать шаблон для таблиц админа
        $path_to_template.= $segments[2]; // admin
        /*if($segments[3]){
            if(isset($_GET['filter'])) {
                // подключить сервис обработки таблицы по фильтру:
                require_once $path_to_files.'api/admin/'.$segments[3].'/'. $action .'.php';
            }
            require_once $path_to_files.'api/admin/'.$last_segment.'.php';
        }*/
    }else
        $path_to_template.= 'user';

}
ob_start();
// подключить шаблон и сохранить все сгенерированные данные в буфере
require_once $path_to_template.'.php';