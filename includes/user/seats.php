<?php
$raw_data = json_decode(
    file_get_contents(
        //API_ROOT.'seances/'.$segments[2]
        API_ROOT.'tickets/seats/seances/'.$segments[2]
    ), true);
//echo $data;
//echo "<h2>Здесь должны быть места. Они есть?</h2>";
require_once dirname(__FILE__).'/../functions/user.php';
echo User::showSeancePlaces($raw_data['all_places'],$raw_data['taken_places']);