<?php
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,API_ROOT."seances/");
unset($_POST['user_post_data']);
$curl_post_data = $_POST;
curl_setopt($curl, CURLOPT_HEADER, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
$result = curl_exec ($curl);
curl_close ($curl);
// перейти в раздел со списком заказанных билетов юзера:
header ("location: ".SITE_ROOT.'orders');
