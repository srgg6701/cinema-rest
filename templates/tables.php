<h3>Таблица: <?php echo $segments[3]; ?></h3>
<?php echo $table;
if($segments[3]!='tickets'){?>
<form method="post" action="">
<h4>Добавить запись:</h4>
<?php echo $table_add;?>
<button type="submit">Добавить</button>
</form>
<?php
}else{
    ?>
    <h4>В эту таблицу данные могут быть добавлены только зрителем</h4>
<?php
}
?>