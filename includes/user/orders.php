<?php
$data = json_decode(
    file_get_contents(
        API_ROOT.'tickets/taken/'
    ), true);