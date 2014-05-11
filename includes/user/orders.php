<?php
$data = json_decode(
    file_get_contents(
        API_ROOT.'tickets/orders/'.$_SESSION['active_user_id']
    ), true); // var_dump("<pre>",$data,"<pre/>");

/* 	action обрабатывается подключаемым к роутеру файлом, имя которого извлекается из 
	значения value элемента с name = user_post_data
	Данный файл должен находиться в /includes/user/[имя_файла] */

?>
<form name="user-form" id="user-form" enctype="application/x-www-form-urlencoded" class="clearfix order" method="post" action="<?php
echo SITE_ROOT;		?>api/tickets/orders/store">
	<input type="hidden" name="user_post_data" value="includes/user/post_order_store">
    <p style="margin-top:">Вы можете изменить заказ, если до начала сеанса осталось не менее 1 часа.</p>
<table class="user_table orders">
<?php   $i=0;
        foreach ($data as $seance_id=>$seance_data) :
            $i++;
    ?>
    <tr class="sub_subheader">
        <th>#</th>
        <th colspan="4">Фильм</th>
        <th>Время начала</th>
    </tr>
    <tr class="movie_name">
        <td><?php echo $i;?></td>
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
            // если есть возможность изменить/отменить заказ:
			if($seance_data['hours_left']):
			?>
            <button type="submit">Сохранить</button>
     <?php 	/** 
	 			следующий элемент нужен для того, чтобы обработчик запроса мог выявить
				ситуацию, когда все чекбоксы были разотмечены, что, по сути, означает
				удаление заказа	*/
			?>
            <input type="hidden" name="user_tickets_id_<?php echo $seance_data['tickets_id'];?>" value="<?php echo $seance_data['tickets_id'];?>">
            <?php 
			
			endif;
			
			?></h5>
            <aside class="floatLeft clearfix">
    <?php   foreach(explode(',' ,$seance_data['taken_places']) as $place):
        ?>
        <label>
        	<input type="checkbox" <?php
            if(intval($seance_data['hours_left'])<1):
                ?> disabled <?php
            endif;?> checked name="seat_<?php
            echo $seance_id;?>"> <?php echo $place;?>
        </label>
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
</form>