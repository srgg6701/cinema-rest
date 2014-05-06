<h2>Пожалуйста, выберите статус/действие:</h2>
<hr>
<div class="floatLeft halfWide">
	<h3 class="box" role="admin">Администратор</h3>
    <p>Вам доступны действия со всеми таблицами БД:</p>
    <ul>    	
    	<?php	getAdminTables();	?>
    </ul>
</div>
<div class="floatLeft halfWide">
	<h3 class="box" role="spectator">Заказчик/зритель</h3>
  <p>Вам доступны следующие действия:</p>
    <ul>
      <li><a href="api/cinema/halls/seances">Просмотр расписания сеансов по кинотеатрам/залам</a></li>
      <li><a href="api/movies/halls">Просмотр залов, в которых идёт выбранный вами фильм</a></li>
      <li><a href="api/seances/free_seats">Проверка наличия свободных мест на сеанс</a></li>
      <li><a href="api/tickets">Заказ билетов</a></li>
      <li><a href="api/tickets/mine">Отмена заказа билетов (не позже, чем за час до начала сеанса).</li>
    </ul>
</div>