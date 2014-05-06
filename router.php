<?php session_start();
$location = mb_split('/',$_SERVER['REQUEST_URI']);
// set root path
$common_path = 'http://'.$_SERVER['HTTP_HOST'];
if($_SERVER['HTTP_HOST']=='127.0.0.1'||$_SERVER['HTTP_HOST']=='localhost')
    $common_path.='/'.$location[1];
define('SITE_ROOT',$common_path.'/');

// распарсить URL на сементы подключения файлов
$segments = array();
foreach(range(1,count($location)) as $index) { // /site_name/segment1/segment2/segment3
    $segments[$index-1]=(isset($location[$index]))? $location[$index]:NULL;
}

// установить корневую директорию подключения файлов (DOCUMENT_ROOT/имя сайта)
if(!defined('FILES_ROOT'))
    define('FILES_ROOT',$_SERVER['DOCUMENT_ROOT'].'/'.$location[1].'/');

// никаких файлов, только сегменты
if(strstr($segments[1], '.php')) {
    header("location:".SITE_ROOT);
}

// базовый путь к шаблонам
$path_to_template_root = $path_to_template   = FILES_ROOT.'templates/';
// базовый путь к ресурсам
$path_to_files      = FILES_ROOT.'api/';

// подключиться к БД (здесь это должно происходить в любом случае)
require_once FILES_ROOT."connect_db.php";
// подключить функции
require_once $path_to_files."functions.php";

$action = mb_strtolower($_SERVER['REQUEST_METHOD']);

if(!$segments[1]){
    $path_to_template.= 'default';
}else{
    // подключить ресурс и шаблон
    if($segments[2])
        // site_name/api/(admin|[table])/
        $path_to_files.=$segments[2].'/';
    if($segments[2]=='admin')
        $path_to_template = $path_to_template_root . 'admin';
    else // если юзер
        $path_to_template = $path_to_template_root . 'user';
    //
    $path_to_files.=$action; //echo "<div>path_to_files = $path_to_files</div>"; //die();
    if(!file_exists($path_to_files.'.php')){
        $error = 'Путь подключения <b>'.$path_to_files.'.php</b> не обнаружен';
        $path_to_template = $path_to_template_root . '404';
    }else{
        ob_start();
        //if($segments[2]!='admin')
            //require_once FILES_ROOT.'api/request.php';
        require_once $path_to_files.'.php'; // api/(admin|[table])/(delete|get|post|put).php
        $content = ob_get_contents();
        ob_end_clean();
    }   // echo "<div>path_to_templates = $path_to_template</div>"; //die();
}
ob_start();
// подключить шаблон и сохранить все сгенерированные данные в буфере
require_once $path_to_template.'.php';