<?php
/**
 * генерация интерфейса управления таблицами БД для админа:
 просмотр, добавление, удаление */
$table_name = $segments[2]; //die("<div>$table_name</div>");
// таблица добавления новой записи
require_once 'partials/add_record.php';
// таблица с данными существующих записей (можно удалять по одной; выполняет каскадное удаление)
require_once 'partials/current_records.php';