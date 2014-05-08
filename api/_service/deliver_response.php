<?php
/**
 * доставить данные клиенту */
header("HTTP/1.1 $status $status_message");
// получает данные из родительского файла
$response['status']=$status;
$response['status_message']=($data)? "Данные получены":"Нет данных для отображения";
$response['data']=$data;