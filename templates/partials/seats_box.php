<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once dirname(__FILE__)."/../../includes/routing/path.php"?>
<form name="user-form" id="user-form" enctype="application/x-www-form-urlencoded" class="clearfix order" method="post" action="<?php
echo SITE_ROOT;?>">
    <div id="places">
        <h4>Укажите нужные места <div class="floatRight close" onclick="hideBox()">Закрыть окно</div></h4>
        <p>(Если вы заказывали места на данном сеансе, они выделены <span class="lightgreen">зелёным</span>.)</p>
        <div id="seats" class="clearfix"><?php
            /**
             * контент подгружается из api/tickets/seats/seances/[id_сеанса] -> getSeats()
             * вызывается клиентским скриптом common.js -> createHall()
            */
        ?></div>
        <input type="hidden" id="active-user-id" name="active_user_id" value="<?php
			echo $_SESSION['active_user_id'];
        ?>">
        <input type="hidden" id="seance-id" name="seance_id" value="">
        <button name="user_post_data" value="includes/user/post_order" type="submit" id="btn-make-order">Сохранить</button>
    </div>
</form>