<?php header('Content-Type: text/html; charset=utf-8');
require_once dirname(__FILE__)."/../../includes/routing/path.php"?>
<form id="user-form" class="clearfix order" method="post" action="<?php
echo SITE_ROOT.'includes/user/check_orders'?>">
    <div id="places">
        <h4>Укажите нужные места <div class="floatRight close" onclick="hideBox()">Закрыть окно</div></h4>
        <div id="seats" class="clearfix">
        </div>
        <button type="submit" id="btn-make-order">Оформить заказ!</button>
    </div>
</form>