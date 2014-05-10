<?php
$data = json_decode(
    file_get_contents(
        API_ROOT.'seances/'.$segments[2]
    ), true);

echo $data;