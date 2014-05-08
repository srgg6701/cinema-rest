<?php // получить все сеансы
if(isset($segments[2])){
    require_once 'singles/seance.php';
}else{
$data = json_decode(
    file_get_contents(
        API_ROOT.'halls/cinema/'
    ), true); //var_dump(getHallsByCinema());
?>
<table class="user_table">
    <tr>
        <th colspan="4" nowrap>
            Кинотеатр, зал, количество мест<br>
            № сеанса, название фильма, время начала, колич. свободных мест
        </th>
    </tr>
    <?php   require_once FILES_ROOT.'api/_service/actions.php';

    foreach(getHallsByCinema() as $cinema=>$hall_array):
        ?>
        <tr class="header cinema">
            <td colspan="4"><?php echo $cinema;?></td>
        <tr>
        <?php
        foreach($hall_array as $id=>$data):
            ?>
            <tr class="header hall">
                <td colspan="4"><a role="schedule" href="halls/<?php echo $id;?>"><?php echo $data[0];?></a></td>
            </tr>
        <?	endforeach;
    endforeach;?>
</table>
<?php
}
