<?php // получить список кинотеатров
require_once '../../../includes/routing/segments.php'; //var_dump("<pre>",$segments,"<pre/>"); die();
require_once '../../_service/actions.php';

header("Content-Type:application/json");

$status = 200;
$data = getHallsByCinema();//

require_once '../../_service/deliver_response.php';

$json_response= json_encode($response);
echo $json_response;