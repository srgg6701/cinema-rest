<h3>Таблица: <?php
    $table_name=$segments[3];
    echo $table_name; ?></h3>
<?php echo $table;
if($table_name!='tickets'){?>
    <form class="clearfix" method="post" action="<?php echo SITE_ROOT.'api/tables/records'?>">
        <h4>Добавить запись:</h4>
        <div class="floatLeft halfWide">
            <?php echo $table_add;?>
            <button class="floatRight" name="table" value="<?php echo $table_name;?>" type="submit">Добавить</button>
        </div>
    </form>
<?php
}else{
    ?>
    <h4>В эту таблицу данные могут быть добавлены только зрителем</h4>
<?php
}
?>