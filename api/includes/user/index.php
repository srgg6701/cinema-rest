<?php
echo('Вы здесь: '.$_SERVER['REQUEST_URI']);
var_dump("<pre>",$_POST,"<pre/>");
die('Отсюда нужен редирект!');