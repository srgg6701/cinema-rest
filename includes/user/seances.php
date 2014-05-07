<?php // получить все сеансы
$data = json_decode(
            file_get_contents(
                API_ROOT.'halls/cinema/get.php'
            ), true);

var_dump('<pre>',$data,'</pre>');
