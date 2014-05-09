<?php
require_once dirname(__FILE__).'/../connect_db.php';
// если запись удалена, возвращаем её id
try{
    deleteRecord($_GET['table'],$_GET['id']);
    echo $_GET['id'];
}catch(Exception $e){
    echo $e->getMessage();
}
exit();
