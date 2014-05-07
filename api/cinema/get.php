<?php // получить список кинотеатров

$status = 200;
$status_message = "Everything all right!";

// get real Common

$data = "Some content. Anything you like";


header("Content-Type:application/json");

// deliver_response
header("HTTP/1.1 $status $status_message");

// gets from parent file where Common comes from
$response['status']=$status;
$response['status_message']=$status_message;
$response['data']=$data;
$json_response= json_encode($response);

echo $json_response;

