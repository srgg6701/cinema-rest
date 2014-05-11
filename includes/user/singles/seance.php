<?php
/**
 * Вызывается при добавлении билетов в просмотре доступных мест в кинозале
 * по выбранному сеансу
 */
$data = json_decode(
    file_get_contents(
        API_ROOT.'seances/'.$segments[2]
    ), true);

echo $data;