<?php
$data = json_decode(
    file_get_contents(
        API_ROOT.'movies/'
    ), true);
$movie_data=$data['data'];?>
<h3>Фильм: <?php echo array_shift($movie_data);?></h3>
<p>Расписание киносеансов и заказ билетов:</p>
<?php
//var_dump("<pre>",$movie_data,"<pre/>");
/*require_once FILES_ROOT.'api/_service/actions.php';
var_dump("<pre>",getMovieSeances($segments[2]),"<pre/>");*/?>
<form id="user-form" class="clearfix" method="post" action="<?php
        echo SITE_ROOT.'api/tickets/index.php'?>">
  <div class="floatLeft">
    <table class="user_table movie">
        <tr>
            <th colspan="4">Кинотеатр,</th>
        </tr>
        <tr class="light_green">
            <th>Зал</th>
            <th>Время начала</th>
            <th nowrap>Св. мест</th>
            <th>Заказать</th>
        </tr>
        <?php
        foreach($movie_data as $cinema=>$stuff):
        ?>
        <tr class="header cinema">
            <th colspan="4"><?php
            echo $cinema;?></th>
        </tr>
        <?php
            foreach($stuff as $seance_id=>$seance_data):
        ?>
        <tr>
            <td><?php echo $seance_data['hall']['hall_name'];?></td>
            <td><?php echo $seance_data['showtime'];?></td>
            <td><?php
                echo $seats=$seance_data['free_seats_numbers']?
                    $seance_data['free_seats_numbers']:"нет";?></td>
            <td><?php
                if(intval($seats)):
                    ?><select name="seance[<?php echo $seance_id;?>]">
                    <option value="0"> :::: </option>
            <?php   while($seats):   ?>
                    <option value="<?php echo $seats?>">
                    <?php echo $seats;?>
                    </option>
            <?php       $seats--;
                    endwhile;?>
                    </select><?php
                endif;
                ?></td>
        </tr>
        <?php
            endforeach;
        endforeach;
            ?>
    </table>
    <button type="submit" class="floatRight">Оформить заказ!</button>
  </div>
</form>
<?php
