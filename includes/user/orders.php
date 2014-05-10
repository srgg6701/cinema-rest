<?php
$data = json_decode(
    file_get_contents(
        API_ROOT.'tickets/orders/'.$_SESSION['active_user_id']
    ), true);
var_dump("<pre>",$data,"<pre/>");