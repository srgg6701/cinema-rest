<?php // получить список кинотеатров
require_once '../../_service/includes.php';
header("Content-Type:application/json");

$status = 200;
$data = getHallsByCinema();//

require_once '../../_service/deliver_response.php';

$json_response= json_encode($response);
echo $json_response;