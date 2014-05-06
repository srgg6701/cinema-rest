<?php echo "<h3>".Data::getOptionName()."</h3>";?>
<br>
<div class="floatLeft" id="user-content">
    Таблицы
<?php

echo $content;

?>
</div>
<div class="floatLeft" id="vertical-menu">
    <menu>
    <?php echo Data::getUserOptions(true);?>
    </menu>
</div>