<?php
if($_POST){ // если получили данные с POST, - подключить скрипт обработки и передать ему управление дальнейшим процессом
    require_once FILES_ROOT.$_POST['user_post_data'].".php";
}