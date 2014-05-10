<?php header('Content-Type: text/html; charset=utf-8');
require_once dirname(__FILE__)."/../../includes/routing/path.php"?>
<form id="user-form" enctype="application/x-www-form-urlencoded" class="clearfix order" method="post" action="<?php
echo SITE_ROOT;?>">
    <div id="places">
        <h4>Укажите нужные места <div class="floatRight close" onclick="hideBox()">Закрыть окно</div></h4>
        <div id="seats" class="clearfix">
        </div>
        <button name="user_post_data" value="includes/user/check_orders" type="submit" id="btn-make-order">Оформить заказ!</button>
    </div>
</form>