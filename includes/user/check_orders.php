<?php
echo "<div>file: ".__FILE__."</div>";
echo "<div>goto: ".API_ROOT."seances/index.php</div>";
var_dump("<pre>",$_POST,"<pre/>");
//die();

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, API_ROOT."seances/index.php");

curl_setopt($curl, CURLOPT_HEADER, 1);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, 'Hello! Remember me?'); //serialize($_POST)

$a = curl_exec($curl);
curl_close($curl);

echo $a;

die();