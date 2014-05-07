<?php // получить список кинотеатров
require_once '../../includes/_rest/actions.php';

header("Content-Type:application/json");

$status = 200;
$status_message = "Данные получены";
// get real data
$data = getSeancesByHall($_GET['id']);//

require_once '../../includes/_rest/deliver_response.php';

$json_response= json_encode($response['data']);
echo $json_response;

