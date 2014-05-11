<?php
/**
 * ВНИМАНИЕ! Если подгружаем контент ajax'ом, необходимо
 * избавиться от всех внешних HTML-элементов и
 * использовать исключительно данные, полученные
 * от сервиса. Это также проверяется в главном
 * шаблоне (/[site_name]/index.php)
*/
if($segments[1]=='seats'&&$segments[2]){
    $except_template=true; // метка отмены загрузки HTML шаблона
    echo $content;
}else{  // обычный способ извлечения данных.
    echo "<h3>".User::setSectionHeader($segments[1])."</h3>";?>
    <br>
    <div class="floatLeft" id="user-content">
    <?php echo $content; ?>&nbsp;
    </div>
    <div class="floatLeft" id="vertical-menu">
        <menu>
        <?php echo User::getUserOptions(true);?>
        </menu>
    </div><?php
}