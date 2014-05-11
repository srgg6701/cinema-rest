<?php

require_once "../includes/connect_db.php";
if(isset($_GET['upd'])&&$_GET['upd']) {
    $query = "UPDATE _colors SET val = val+$_GET[upd];
    UPDATE cinema._countries cntr
      SET  color_val = (SELECT val FROM _colors WHERE id = cntr.id)
      WHERE color_id IN (1, 2,3,4,5)";
    $result = $connect->exec($query);
    echo "<div>result: $result</div>";
}