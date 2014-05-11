<?php session_start();
require_once 'path.php';

// никаких файлов, только сегменты!
if(isset($segments[1]) && strstr($segments[1], '.php')) {
    header("location:".SITE_ROOT);
}
// базовый путь к шаблонам
$path_to_template_root = $path_to_template = FILES_ROOT.'templates/';
// базовый путь к ресурсам
$path_to_files = FILES_ROOT."includes/";
// проверить - не отсылались ли данные юзером методом POST
require_once dirname(__FILE__).'/check_post_data.php';
// подключить функции
require_once $path_to_files."functions/admin.php";
require_once $path_to_files."functions/user.php";
// определить окончательные параметры подключения шаблонов и служебных файлов
if(!isset($segments[1])){
    $path_to_template.= 'default';
}else{

    if(in_array('admin',$segments)){
        /**
            /[site_name]/includes/admin/read.php
            - функция по умолчанию
            нечто вроде примитивного front-controller'а. */
        $path_to_files.='admin/read';
        // подключить шаблоны
        $path_to_template.='admin';
    }else{
        //  /[site_name]/includes/user/
        $path_to_files.='user/';
        /**
            ВНИМАНИЕ! следующий сегмент подключается (в качестве
            имени файла [file_name] для require_once) в файле
            /[site_name]/includes/user/[file_name] секции юзера. */
        $user_include =$path_to_files.$segments[1];
        //
        $path_to_files.='default';
        //
        $path_to_template.='user';
        //echo "<div>user_include: ".$user_include.".php</div>";
        //echo "<div>path_to_files: ".$path_to_files.".php</div>";
    }   //echo "<div>path_to_files: ".$path_to_files.".php</div>";
    // если зашли в тупик -
    if(!file_exists($path_to_files.'.php')
       || (isset($user_include)
          && ( !file_exists($user_include.'.php')
               || $user_include==$path_to_files )
            ) ) {
        $wrong_file_path=(isset($user_include)) ?
            $user_include:$path_to_files;
        if($user_include==$path_to_files)
            $error = 'Указанный путь подключения не может быть обработан';
        else
            $error = 'Путь подключения <b>'.$wrong_file_path.'.php</b> не обнаружен';
        $path_to_template = $path_to_template_root . '404';
    }else{  //echo "<div>path_to_files: ".$path_to_files.".php</div>"; die();
        /**
         сохранить в буфере сгенерированный контент, чтобы далее
         вставить его в выбранный шаблон  */
        ob_start();
        // /[site_name]/includes/(admin|user)[/.../][file_name].php
        require_once $path_to_files.'.php';
        $content = ob_get_contents();
        ob_end_clean();
    }   // echo "<div>path_to_templates = $path_to_template</div>"; //die();
}
ob_start();
// подключить шаблон и сохранить все сгенерированные данные в буфере
    require_once $path_to_template.'.php';