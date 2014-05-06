<?php
$db_name='cinema';
$dsn = 'mysql:host=localhost;dbname='.$db_name;
$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
try {
	$connect = new PDO($dsn, 'root', '', $options);
} catch (PDOException $e) {
	echo 'Подключиться не удалось. Причина: ' . $e->getMessage();
} 
