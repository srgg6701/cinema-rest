<?php
// получить сегменты URL
require_once 'segments.php';
// set root path
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

/*echo "<div>SERVER_NAME: ".$_SERVER['SERVER_NAME']."</div>";
echo "<div>DOCUMENT_ROOT: ".$_SERVER['DOCUMENT_ROOT']."</div>";
echo "<div>HTTP_HOST: ".$_SERVER['HTTP_HOST']."</div>";
echo "<div><b>location:</b></div>";
var_dump("<pre>",$location,"<pre/>");
echo "<div><b>segments:</b></div>";
var_dump("<pre>",$segments,"<pre/>");
echo "<div>SITE_ROOT: ".SITE_ROOT."</div>";
echo "<div>API_ROOT: ".API_ROOT."</div>";
echo "<div>FILES_ROOT: ".FILES_ROOT."</div>";*/

