<?php session_start();
$location = mbsplit('/',$_SERVER['REQUEST_URI']);
// set root path
if(!defined('SITE_ROOT')){
    $common_path = 'http://'.$_SERVER['HTTP_HOST'];
    if($_SERVER['HTTP_HOST']=='127.0.0.1'||$_SERVER['HTTP_HOST']=='localhost')
        $common_path.='/'.$location[1];
    define('SITE_ROOT',$common_path);
}

$api_path=null;
if(in_array('api',$location)) $api_path='';
$segments = array();
foreach(range(1,3) as $index) { // /site_name/segment1/segment2/segment3
    $segments[$index-1]=(isset($location[$index]))? $location[$index]:NULL;
    if($api_path!==null)
        $api_path.'/'.$segments[$index-1];
}

require_once 'connect_db.php';

if($api_path) {
    require_once $api_path;
}
$template_path = $_SERVER['DOCUMENT_ROOT'].'/'.$location[1].'/templates/';

if(!isset($_SESSION['user_type'])){
    $template_path.= 'default';
}else{
    $template.= $_SESSION['user_type'];
}
ob_start();
echo "<div>".$_SERVER['DOCUMENT_ROOT']."</div>";
// var_dump("<pre>",$segments,"<pre/>");
require_once $template_path.'.php';