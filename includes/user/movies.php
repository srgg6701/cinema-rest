<?php
if(isset($segments[2])){
    require_once 'singles/movie.php';
}else{?>
    <h3>Запрос сервиса не получен</h3>
<?php
}