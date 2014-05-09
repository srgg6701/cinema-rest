<?php
/**
 * доставить данные клиенту */
$status_message = ($data)? "Данные получены":"Нет данных для отображения";
header("HTTP/1.1 $status $status_message");
// получает данные из родительского файла
$response['status']=$status;
$response['status_message']=$status_message;
$response['data']=$data;