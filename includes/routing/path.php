<?php
// получить сегменты URL
require_once 'segments.php';
// установить универсальный путь для роутинга
// c:/WebServers/home/localhost/www
// C:/PHPDevServer/data/localweb
$common_path = 'http://'.$_SERVER['HTTP_HOST'];
if($_SERVER['HTTP_HOST']=='127.0.0.1'||$_SERVER['HTTP_HOST']=='localhost')
    $common_path.='/'.$location[1];
if($location_index_plus){
    $common_path.='/'.$location[2];
    define('FILES_ROOT',$_SERVER['DOCUMENT_ROOT'].'/'.$location[1].'/'.$location[2].'/');
}else // установить корневую директорию подключения файлов (DOCUMENT_ROOT/имя сайта)
    define('FILES_ROOT',$_SERVER['DOCUMENT_ROOT'].'/'.$location[1].'/');

define('SITE_ROOT',$common_path.'/');
define('API_ROOT', SITE_ROOT.'api/');

// подключиться к БД (здесь это должно происходить в любом случае)
require_once dirname(__FILE__)."/../connect_db.php";