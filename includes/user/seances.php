<?php // получить все сеансы
if($segments[2]){
    require_once 'seance.php';
}else{
$data = json_decode(
    file_get_contents(
        API_ROOT.'halls/cinema/get.php'
    ), true);
require_once FILES_ROOT.'includes/_rest/actions.php'; //var_dump(getHallsByCinema());
?>
<table class="user_table">
    <tr>
        <th colspan="4" nowrap>
            Кинотеатр, зал, количество мест<br>
            № сеанса, название фильма, время начала, колич. свободных мест
        </th>
    </tr>
    <?php
    foreach(getHallsByCinema() as $cinema=>$hall_array):
        ?>
        <tr class="header">
            <td colspan="4"><?php echo $cinema;?></td>
        <tr>
        <?php
        foreach($hall_array as $id=>$data):
            ?>
            <tr class="header">
                <td colspan="3"><a role="schedule" href="halls/<?php echo $id;?>"><?php echo $data[0];?></a></td>
                <td><?php echo $data[1];?></td>
            </tr>
        <?	endforeach;
    endforeach;?>
</table>
<?php
}
