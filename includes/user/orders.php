<?php
$data = json_decode(
    file_get_contents(
        API_ROOT.'tickets/orders/'.$_SESSION['active_user_id']
    ), true); 

/* 	action обрабатывается подключаемым к роутеру файлом, имя которого извлекается из 
	значения value элемента с name = user_post_data
	Данный файл должен находиться в /includes/user/[имя_файла] */

	$form_start='<form enctype="application/x-www-form-urlencoded" class="clearfix order" method="post" action="'.SITE_ROOT;

	$form_start.='">
	<input type="hidden" name="user_post_data" value="includes/user/post_order_store">'?>
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
        <?php echo $form_start;?>
            <h5 class="floatLeft">Ваши места:<?php
            // если есть возможность изменить/отменить заказ:
			if($seance_data['hours_left']):
			?>
            <button type="submit">Сохранить</button>
     <?php 	/** 
	 			следующий элемент нужен для того, чтобы обработчик запроса мог выявить
				ситуацию, когда все чекбоксы были разотмечены, что, по сути, означает
				удаление заказа	*/
			
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
			echo $place . "_" . $seance_id;?>" value="<?php echo $place;?>"> <?php echo $place;?>
        </label>
    <?php
    endforeach;?>
            </aside>
        <input type="hidden" name="tickets_id" value="<?php echo $seance_data['tickets_id'];?>">
        <input type="hidden" name="seance_id" value="<?php echo $seance_id;?>">
    <?php echo '</form>';?>
        </td>
    </tr>
    <?php
        endforeach;
		if(!isset($seance_id)):?>
     <tr>
     	<td colspan="6">Вы ещё ничего не заказали :(</td>
     </tr>
<?php 	endif;?>
</table>