<?php // получить все сеансы

$url= API_ROOT.'cinema/get.php';
$response = file_get_contents($url);
$data = json_decode($response, true);
var_dump($data);
