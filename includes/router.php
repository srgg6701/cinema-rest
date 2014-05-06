<?php session_start();

require_once 'path.php';

// никаких файлов, только сегменты
if(strstr($segments[1], '.php')) {
    header("location:".SITE_ROOT);
}

// базовый путь к шаблонам
$path_to_template_root = $path_to_template = FILES_ROOT.'templates/';
// базовый путь к ресурсам
$path_to_files = FILES_ROOT."includes/";
// подключить функции
require_once $path_to_files."functions.php";
// определить окончательные параметры подключения шаблонов и служебных файлов
if(!$segments[1]){
    $path_to_template.= 'default';
}else{

    if(in_array('admin',$segments)){
        //  /[site_name]/includes/admin/(delete|get|post|put)
        $path_to_files.='admin/'.mb_strtolower($_SERVER['REQUEST_METHOD']);
        $path_to_template.='admin';
    }else{
        //  /[site_name]/includes/user
        $path_to_files.='user';
        $path_to_template.='user';
    }
    // если вломились в пустоту
    if(!file_exists($path_to_files.'.php')){
        $error = 'Путь подключения <b>'.$path_to_files.'.php</b> не обнаружен';
        $path_to_template = $path_to_template_root . '404';
    }else{  //echo "<div>path_to_files: ".$path_to_files.".php</div>"; die();
        ob_start();
        // /[site_name]/(admin|api/[table])/(delete|get|post|put).php
        require_once $path_to_files.'.php';
        $content = ob_get_contents();
        ob_end_clean();
    }   // echo "<div>path_to_templates = $path_to_template</div>"; //die();
}
ob_start();
// подключить шаблон и сохранить все сгенерированные данные в буфере
require_once $path_to_template.'.php';