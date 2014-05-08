<?php
require_once '../../_service/includes.php';

header("Content-Type:application/json");
$status = 200;
$data = getSeats($segments[4]);//
require_once '../../_service/deliver_response.php';

$json_response= json_encode($response['data']);
echo $json_response;