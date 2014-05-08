<?php
$data = json_decode(
    file_get_contents(
        API_ROOT.'seances/get.php?id='.$segments[2]
    ), true);

echo $data;