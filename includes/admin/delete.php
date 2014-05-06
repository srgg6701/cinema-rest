<?php
// если запись удалена, возвращаем её id
if($connect->exec("DELETE FROM $segments[2] WHERE id = $segments[3]")){ // table id, record id
    echo $segments[3];
    exit();
}