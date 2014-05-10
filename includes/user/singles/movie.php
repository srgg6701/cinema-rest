<?php
$data = json_decode(
    file_get_contents(
        API_ROOT.'movies/'.$segments[2]
    ), true);
$movie_data=$data['data'];
//echo "file: ". API_ROOT.'movies/'.$segments[2];?>
<h3>Фильм: <?php echo array_shift($movie_data);?></h3>
<p>Расписание киносеансов.<br>
    Для заказа билетов щёлкайте кнопки
    с колич. свободных мест.</p>
<?php
//var_dump("<pre>",$movie_data,"<pre/>");
/*require_once FILES_ROOT.'api/_service/actions.php';
var_dump("<pre>",getMovieSeances($segments[2]),"<pre/>");*/?>
<div class="floatLeft">
    <table id="tbl-order" class="user_table movie">
        <tr>
            <th colspan="3">Кинотеатр,</th>
        </tr>
        <tr class="light_green">
            <th>Зал</th>
            <th>Время начала</th>
            <th nowrap>Св. мест</th>
        </tr>
        <?php
        foreach($movie_data as $cinema=>$stuff):
        ?>
        <tr class="header cinema">
            <th colspan="3"><?php
            echo $cinema;?></th>
        </tr>
        <?php
            foreach($stuff as $seance_id=>$seance_data):
        ?>
        <tr>
            <td><?php echo $seance_data['hall']['hall_name'];?></td>
            <td><?php echo $seance_data['showtime'];?></td>
            <td><button role="show_hall_places" type="button" value="<?php
                echo $seance_id;?>"><?php
                echo $seats=$seance_data['free_seats_numbers']?
                    $seance_data['free_seats_numbers']:"нет";?></button></td>
        </tr>
        <?php
            endforeach;
        endforeach;
            ?>
    </table>
</div>
