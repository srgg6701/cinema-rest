<?php
// если запись удалена, возвращаем её id
if(deleteRecord($segments[3],$segments[4])){
    echo $segments[4];
    exit();
}