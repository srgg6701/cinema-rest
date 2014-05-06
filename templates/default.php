<h2>Пожалуйста, выберите статус/действие:</h2>
<hr>
<div class="floatLeft halfWide">
	<h3 class="box" role="admin">Администратор</h3>
    <p>Вам доступны действия со всеми таблицами БД:</p>
    <ul>    	
    	<?php	Data::getAdminTables();	?>
    </ul>
</div>
<div class="floatLeft halfWide">
	<h3 class="box" role="spectator">Заказчик/зритель</h3>
  <p>Вам доступны следующие действия:</p>
    <ul>
	<?php echo Data::getUserOptions(true);?>
    </ul>
</div>