<?php
//echo "<div>file: ".__FILE__."</div>";
//echo "<div>goto: ".API_ROOT."seances/index.php</div>";
//var_dump("<pre>",$_POST,"<pre/>");
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,API_ROOT."seances/index.php");
unset($_POST['user_post_data']);
$curl_post_data = $_POST;
curl_setopt($curl, CURLOPT_HEADER, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data); //$_POST
curl_exec ($curl);
curl_close ($curl);

header ("location: ".SITE_ROOT.'orders');

/*$decoded = json_decode($curl_response);
if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('error occured: ' . $decoded->response->errormessage);
}*/

//die();