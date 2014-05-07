<?php

$data = "<h1>Hello! Wanna a single seance?!</h1><h2>Ok, my ID is ".$_GET['id']."</h2>";

echo json_encode($data);