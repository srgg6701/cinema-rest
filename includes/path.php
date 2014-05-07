<?php
$location = mb_split('/',$_SERVER['REQUEST_URI']);
// set root path
$common_path = 'http://'.$_SERVER['HTTP_HOST'];
if($_SERVER['HTTP_HOST']=='127.0.0.1'||$_SERVER['HTTP_HOST']=='localhost')
    $common_path.='/'.$location[1];
define('SITE_ROOT',$common_path.'/');
define('API_ROOT', SITE_ROOT.'api/');

// распарсить URL на сементы подключения файлов
$segments = array();
foreach(range(1,count($location)) as $index) { // /site_name/segment1/segment2/segment3
    $segments[$index-1]=(isset($location[$index]))? $location[$index]:NULL;
}

// установить корневую директорию подключения файлов (DOCUMENT_ROOT/имя сайта)
define('FILES_ROOT',$_SERVER['DOCUMENT_ROOT'].'/'.$location[1].'/');

// подключиться к БД (здесь это должно происходить в любом случае)
require_once FILES_ROOT."includes/connect_db.php";