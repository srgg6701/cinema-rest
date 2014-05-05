<?php session_start();
$location = mbsplit('/',$_SERVER['REQUEST_URI']);
// set root path
if(!defined('SITE_ROOT')){
    $common_path = 'http://'.$_SERVER['HTTP_HOST'];
    if($_SERVER['HTTP_HOST']=='127.0.0.1'||$_SERVER['HTTP_HOST']=='localhost')
        $common_path.='/'.$location[1];
    define('SITE_ROOT',$common_path);
}
$segments = array();
$included_file=(in_array('api',$location))? 'api':'';
foreach(range(1,3) as $index) { // /site_name/segment1/segment2/segment3
    $segments[$index-1]=(isset($location[$index]))? $location[$index]:NULL;
    $included_file.'/'.$segments[$index-1];
}   // var_dump("<pre>",$segments,"<pre/>");
require_once 'connect_db.php';
echo "<div>".$included_file."</div>";
//require_once $included_file;