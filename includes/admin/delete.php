<?php
// если запись удалена, возвращаем её id
if(deleteRecord($segments[2],$segments[3])){ // table id, record id
    echo $segments[3];
    exit();
}