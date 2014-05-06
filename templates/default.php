<h2>Пожалуйста, укажите свой статус:</h2>
<hr>
<div class="floatLeft halfWide">
	<h3>Администратор</h3>
    <p>Вам доступны любые действия со всеми таблицами БД:</p>
    <ul>    	
    	<?php
		$query = 'SELECT table_name FROM information_schema.TABLES 
 WHERE table_schema = "'.$db_name.'" ORDER BY table_name';
 		foreach($connect->query($query,PDO::FETCH_ASSOC) as $table_name):?>
        	<li><a href="<?php echo SITE_ROOT;?>api/tables/<?php 
			echo $table_name['table_name'];?>"><?php 
			echo $table_name['table_name'];?></a>
        	</li>
		<?php
		endforeach;
		?>
    </ul>
</div>
<div class="floatLeft halfWide">
	<h3>Заказчик/зритель</h3>
  <p>Вам доступны следующие действия:</p>
    <ul>
      <li><a href="api/cinema/halls/seances">Просмотр расписания сеансов по кинотеатрам/залам</a></li>
      <li><a href="api/movies/halls">Просмотр залов, в которых идёт выбранный вами фильм</a></li>
      <li><a href="api/seances/free_seats">Проверка наличия свободных мест на сеанс</a></li>
      <li><a href="api/tickets">Заказ билетов</a></li>
      <li><a href="api/tickets/mine">Отмена заказа билетов (не позже, чем за час до начала сеанса).</li>
    </ul>
</div>