<?php
$data = json_decode(
    file_get_contents(
        API_ROOT.'tickets/orders/'.$_SESSION['active_user_id']
    ), true);
// var_dump("<pre>",$data,"<pre/>");
?>
<form name="user-form" id="user-form" enctype="application/x-www-form-urlencoded" class="clearfix order" method="post" action="<?php
echo SITE_ROOT;?>">
    <p style="margin-top:">Вы можете изменить заказ, если до начала сеанса осталось не менее 1 часа.</p>
<table class="user_table orders">
<?php   $i=0;
        foreach ($data as $seance_id=>$seance_data) :
            $i++;
    ?>
    <tr>
        <th>#</th>
        <th colspan="4">Фильм</th>
        <th>Время начала</th>
    </tr>
    <tr class="movie_name">
        <td><?php echo $i;?>
            <input type="hidden" id="seance-id" name="seance_id" value="<">
        </td>
        <td colspan="4"><?php echo $seance_data['movie_name'];?></td>
        <td><?php echo $seance_data['showtime'];?></td>
    </tr>
    <tr class="subheaders">
        <th colspan="6">Кинотеатр, Зал, Осталось часов до начала сеанса:</th>
    </tr>
    <tr class="second">
        <td colspan="5">
            <?php echo $seance_data['cinema_name'];?>,
        <?php echo $seance_data['halls_name'];?>
        <td><?php echo $seance_data['hours_left'];?></td>
    </tr>
    <tr class="boxes">
        <td colspan="6">
            <h5 class="floatLeft">Ваши места:<?php
            if($seance_data['hours_left']):?>
                <button type="submit" name="btn_seance_id_<?php
                echo $seance_id;?>">Отменить сеанс</button>
            <?php endif;?>
            </h5>
            <aside class="floatLeft clearfix">
    <?php   foreach(explode(',' ,$seance_data['taken_places']) as $place):
        ?>
        <label><input type="checkbox" <?php
            if(intval($seance_data['hours_left'])<1):
                ?> disabled <?php
            endif;?> checked name="seance_<?php
            echo $seance_id;?>_<?php echo $place;?>">
            <?php echo $place;?></label>
    <?php
    endforeach;?>
            </aside>
        </td>
    </tr>
    <?php
        endforeach;
?>
</table>
    <input type="hidden" id="active-user-id" name="active_user_id" value="<?php
    echo $_SESSION['active_user_id'];
    ?>">
    <button name="user_post_data" value="includes/user/change_order" type="submit" id="btn-make-order">Подтвердить изменения!</button>
</form>