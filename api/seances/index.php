<?php
require_once '../_service/includes.php';
var_dump("<pre>",$_POST,"<pre/>");
// добавить записи в табл. заказов билетов
$result = handleOder($_POST);
echo "<div>Обновлено записей (колич. свободных мест)
        в табл. 'cinema_seances': " .
    $result."</div>"; die();