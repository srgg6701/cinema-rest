<h3>Таблица: <?php echo $segments[3]; ?></h3>
<?php echo $table;
if($segments[3]!='tickets'){?>
<form method="post" action="<?php echo SITE_ROOT.'api/table_records.php'?>">
<h4>Добавить запись:</h4>
<div class="floatLeft halfWide">
    <?php echo $table_add;?>
<button class="floatRight" type="submit">Добавить</button>
</div>
</form>
<?php
}else{
    ?>
    <h4>В эту таблицу данные могут быть добавлены только зрителем</h4>
<?php
}
?>