<?php session_start();
$location = mb_split('/',$_SERVER['REQUEST_URI']);
// set root path
if(!defined('SITE_ROOT')){
    $common_path = 'http://'.$_SERVER['HTTP_HOST'];
    if($_SERVER['HTTP_HOST']=='127.0.0.1'||$_SERVER['HTTP_HOST']=='localhost')
        $common_path.='/'.$location[1];
    define('SITE_ROOT',$common_path.'/');
}

// распарсить URL на сементы подключения файлов
$segments = array();
foreach(range(1,count($location)) as $index) { // /site_name/segment1/segment2/segment3
    $segments[$index-1]=(isset($location[$index]))? $location[$index]:NULL;
}

// установить корневую директорию подключения файлов (DOCUMENT_ROOT/имя сайта)
if(!defined('FILES_ROOT'))
    define('FILES_ROOT',$_SERVER['DOCUMENT_ROOT'].'/'.$location[1].'/');
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
    // модифицировать путь подключения файлов
    if($segments[2])
        // site_name/api/(admin|cinema|halls|movies|tickets)/
        $path_to_files.=$segments[2].'/';
    // подключить ресурс и шаблон
    /*if($segments[2]=='admin'){ // если админ
        // GET | POST: site_name/api/admin/ -> (get|post).php
        $path_to_files.=$action;
        // будем подключать шаблон для таблиц админа
        $path_to_template = $path_to_template_root . $segments[2]; // admin
    }*/
    if($segments[2]=='admin')
        $path_to_template = $path_to_template_root . 'admin';
    else{ // если юзер
        $path_to_template = $path_to_template_root . 'user'; /*
        if(in_array('filter',$segments)) {
            $key_filter = array_search('filter',$segments)+1;
            $filter_name = $segments[$key_filter];
            $filter_value = $segments[$key_filter+1];
            switch($filter_name){
                case '':
                    break;
            }
        }*/
        // GET | POST: site_name/api/[table]/ -> (get|post).php
        if(isset($segments[3]))
            $path_to_files.=$segments[3].'/';
    }
    $path_to_files.=$action;
    //echo "<div>path_to_files = $path_to_files</div>"; die();
    if(!file_exists($path_to_files.'.php')){
        $error = 'Путь подключения <b>'.$path_to_files.'.php</b> не обнаружен';
        $path_to_template = $path_to_template_root . '404';
    }else
        require_once $path_to_files.'.php';
    //echo "<div>path_to_templates = $path_to_template</div>"; die();
}
ob_start();
// подключить шаблон и сохранить все сгенерированные данные в буфере
require_once $path_to_template.'.php';