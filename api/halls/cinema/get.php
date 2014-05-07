<?php // получить список кинотеатров
require_once '../../../includes/_rest/actions.php';

$status = 200;
$status_message = "Everything all right!";
// get real data
$data = getHallsByCinema();//


header("Content-Type:application/json");

require_once '../../../includes/_rest/deliver_response.php';

$json_response= json_encode($response);
echo $json_response;

