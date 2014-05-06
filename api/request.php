<?php
header("Content-Type:application/json");

    // deliver_response
    header("HTTP/1.1 $status $status_message");

    // gets from parent file where data comes from
    $response['status']=$status;
    $response['status_message']=$status_message;
    $response['data']=$data;
    $json_response= json_encode($response);