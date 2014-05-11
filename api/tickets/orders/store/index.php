<?php
require_once '../../../_service/includes.php';
echo "<div>file: ".__FILE__."</div>";
var_dump("<pre>",$_POST,"<pre/>"); // die();
/**
 * обработать набор билетов.
Далее включится перенаправление, т.о.,
Текущая процедура нужна исключительно для
обработки данных на стороне сервиса. */
storeUserOrdersSet($_POST);