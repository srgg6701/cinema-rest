<?php // получить список кинотеатров
require_once '../../../includes/routing/segments.php';
var_dump("<pre>",$segments,"<pre/>");
die();
require_once '../../../includes/_rest/actions.php';

header("Content-Type:application/json");

$status = 200;
$status_message = "Данные получены";
// get real data
$data = getHallsByCinema();//

require_once '../../../includes/_rest/deliver_response.php';

$json_response= json_encode($response);
echo $json_response;