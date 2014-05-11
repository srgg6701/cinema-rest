<?php
$raw_data = json_decode(
    file_get_contents(
        API_ROOT.'tickets/seats/seances/'.$segments[2]
    ), true);
require_once dirname(__FILE__).'/../functions/user.php';
echo User::showSeancePlaces($raw_data['all_places'],$raw_data['taken_places']);