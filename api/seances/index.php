<?php
require_once '../_service/includes.php';

header("Content-Type:application/json");
$status = 200;
$data = "Здесь будет список всех сеансов, когда это потребуется.";//getSeancesByHall($segments[3]);//
require_once '../_service/deliver_response.php';

$json_response= json_encode($response['data']);
echo $json_response;
